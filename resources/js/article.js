class ArticleFilter {
    constructor() {
        this.activeTag = 'all';
        this.searchQuery = '';
        this.articles = [];
        this.init();
    }

    init() {
        // Cache DOM elements
        this.tagButtons = document.querySelectorAll('[data-tag]');
        this.searchInput = document.querySelector('#article-search');
        this.articlesContainer = document.querySelector('#articles-grid');

        // Bind events
        this.tagButtons.forEach(btn => {
            btn.addEventListener('click', () => this.handleTagFilter(btn.dataset.tag));
        });

        this.searchInput?.addEventListener('input', debounce((e) => {
            this.handleSearch(e.target.value);
        }, 300));

        // Initial fetch
        this.fetchArticles();
    }

    async fetchArticles() {
        try {
            const response = await fetch(`/api/articles?tag=${this.activeTag}&search=${this.searchQuery}`);
            const data = await response.json();
            this.articles = data;
            this.renderArticles();
        } catch (error) {
            console.error('Error fetching articles:', error);
        }
    }

    handleTagFilter(tag) {
        // Update active state
        this.tagButtons.forEach(btn => {
            btn.classList.toggle('active-tag', btn.dataset.tag === tag);
        });

        // Animate out
        this.articlesContainer.style.opacity = '0';
        this.articlesContainer.style.transform = 'translateY(20px)';

        setTimeout(() => {
            this.activeTag = tag;
            this.fetchArticles();
        }, 300);
    }

    handleSearch(query) {
        this.searchQuery = query;
        this.fetchArticles();
    }

    renderArticles() {
        // Prepare animation
        this.articlesContainer.style.opacity = '0';
        this.articlesContainer.style.transform = 'translateY(20px)';

        // Generate HTML
        const html = this.articles.map(article => `
            <article class="article-card" data-tag="${article.tag}">
                <div class="p-6">
                    <div class="tag-badge ${this.getTagClass(article.tag)}">
                        ${article.tag}
                    </div>
                    <h3 class="article-title">${article.judul}</h3>
                    <p class="article-excerpt">${article.excerpt}</p>
                </div>
            </article>
        `).join('');

        // Update DOM and animate in
        this.articlesContainer.innerHTML = html;
        requestAnimationFrame(() => {
            this.articlesContainer.style.opacity = '1';
            this.articlesContainer.style.transform = 'translateY(0)';
        });
    }

    getTagClass(tag) {
        const classes = {
            penyakit: 'tag-disease',
            perawatan: 'tag-care',
            default: 'tag-default'
        };
        return classes[tag] || classes.default;
    }
}

// Debounce utility
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    new ArticleFilter();
});