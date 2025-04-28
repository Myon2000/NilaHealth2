import matplotlib
matplotlib.use('Agg') 

from flask import Flask, request, jsonify, send_from_directory
import tensorflow as tf
import numpy as np
import os
from tensorflow.keras.preprocessing import image
from tensorflow.keras.applications.efficientnet import preprocess_input
from werkzeug.utils import secure_filename
import matplotlib.pyplot as plt
import json
import mysql.connector
from mysql.connector import Error
import logging

# === Flask Setup ===
app = Flask(__name__)
UPLOAD_FOLDER = 'uploads'
ORIGINAL_FOLDER = os.path.join(UPLOAD_FOLDER, 'original')
PREDICT_FOLDER = os.path.join(UPLOAD_FOLDER, 'predict')

# Create folders if not exist
os.makedirs(ORIGINAL_FOLDER, exist_ok=True)
os.makedirs(PREDICT_FOLDER, exist_ok=True)

# === Load Model & Class Names ===
try:
    model = tf.keras.models.load_model("model/efficientnet_model.keras")
    with open("model/class_names.json", "r") as f:
        class_names = json.load(f)
except Exception as e:
    app.logger.error(f"Error loading model or class names: {e}")
    raise

# === Database Connection ===
def get_db_connection():
    try:
        connection = mysql.connector.connect(
            host='127.0.0.1', 
            user='root',  
            password='',  
            database='nilahealth_v1'  
        )
        return connection
    except Error as e:
        app.logger.error(f"Error connecting to database: {e}")
        return None

# === Helper: Preprocess Image ===
def load_and_preprocess(img_path, img_size=(224, 224)):
    try:
        img = image.load_img(img_path, target_size=img_size)
        x = image.img_to_array(img)
        x = np.expand_dims(x, axis=0)
        x = preprocess_input(x)
        return x
    except Exception as e:
        app.logger.error(f"Error processing image {img_path}: {e}")
        raise

# === Helper: Create Prediction Image ===
def create_prediction_image(img_path, prediction_text, save_path):
    try:
        img = image.load_img(img_path, target_size=(224, 224))
        plt.figure(figsize=(6,6))
        plt.imshow(img)
        plt.axis('off')

        ax = plt.gca()
        rect = plt.Rectangle(
            (0, 0), img.width, img.height,
            linewidth=4, edgecolor='lime', facecolor='none'
        )
        ax.add_patch(rect)

        plt.text(
            10, 30, prediction_text,
            color='white', fontsize=14, weight='bold',
            bbox=dict(facecolor='green', alpha=0.7, pad=5)
        )

        plt.savefig(save_path, bbox_inches='tight')
        plt.close()  
    except Exception as e:
        app.logger.error(f"Error creating prediction image for {img_path}: {e}")
        raise

# === Routes ===
@app.route("/")
def home():
    return "✅ NilaHealth Flask API is running. Use /predict for POST image."

@app.route("/predict", methods=["POST"])
@app.route("/predict", methods=["POST"])
def predict():
    if 'image' not in request.files:
        app.logger.error("No file uploaded.")
        return jsonify({"error": "No file uploaded"}), 400

    file = request.files['image']
    filename = secure_filename(file.filename)

    original_path = os.path.join(ORIGINAL_FOLDER, filename)
    try:
        file.save(original_path)
    except Exception as e:
        app.logger.error(f"Error saving original image: {e}")
        return jsonify({"error": "Error saving image file."}), 500

    try:
        x = load_and_preprocess(original_path)
        preds = model.predict(x)
        proba = preds[0]
        idx = np.argmax(proba)
        confidence = float(proba[idx])
        label = class_names[idx]
        label_text = f"{label} ({confidence * 100:.2f}%)"

        predicted_name = f"pred_{filename}.png"
        predicted_path = os.path.join(PREDICT_FOLDER, predicted_name)
        create_prediction_image(original_path, label_text, predicted_path)

        connection = get_db_connection()
        if not connection:
            return jsonify({"error": "Error connecting to database."}), 500

        cursor = connection.cursor(dictionary=True)
        sql = """
          SELECT d.hasil_diagnosis,
                 p.deskripsi AS recommendation
          FROM diagnoses d
          LEFT JOIN penanganans p
            ON p.diagnosis_id = d.id
          WHERE d.hasil_diagnosis = %s
        """
        cursor.execute(sql, (label,))
        row = cursor.fetchone()
        connection.close()

        if row and row["recommendation"]:
            rec = row["recommendation"]
        else:
            rec = "No recommendations available."

        result = {
            "prediction": label,
            "confidence": round(confidence * 100, 2),
            "original_image_url": f"/uploads/original/{filename}",
            "predicted_image_url": f"/uploads/predict/{predicted_name}",
            "recommendation": rec
        }

        if confidence < 0.75:
            result["warning"] = "Pastikan gambar yang kamu upload adalah gambar Nile Tilapia."

        return jsonify(result)

    except Exception as e:
        app.logger.error(f"Error in prediction process: {e}")
        return jsonify({"error": f"Prediction failed: {str(e)}"}), 500

# === Allow access to uploaded images ===
@app.route('/uploads/<folder>/<filename>')
def uploaded_file(folder, filename):
    folder_path = os.path.join(UPLOAD_FOLDER, folder)
    return send_from_directory(folder_path, filename)

# === Run Server ===
if __name__ == "__main__":
    app.run(debug=True)
