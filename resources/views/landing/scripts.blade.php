<script>
document.addEventListener('DOMContentLoaded', () => {

    // ===== SCROLL REVEAL =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                if (entry.target.querySelector('.counter')) {
                    startCounters(entry.target);
                }
                entry.target.querySelectorAll('.progress-animated').forEach(bar => {
                    bar.classList.add('running');
                });
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));

    // Also start hero progress bar immediately
    const heroBar = document.getElementById('heroProgressBar');
    if (heroBar) {
        setTimeout(() => heroBar.classList.add('running'), 800);
    }

    // ===== COUNTER ANIMATION =====
    function startCounters(container) {
        container.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.getAttribute('data-target');
            if (target === 0) { counter.innerText = '0'; return; }
            const duration = 1800;
            const step = 16;
            const increment = target / (duration / step);
            let current = 0;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.innerText = Math.ceil(current).toLocaleString('id-ID');
            }, step);
        });
    }

    // ===== NAVBAR SCROLL =====
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 30);
    }, { passive: true });

    // ===== AUTO-OPEN MODAL =====
    const urlParams = new URLSearchParams(window.location.search);
    const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    if (urlParams.get('login') === '1' || hasErrors) {
        openLoginModal();
        if (hasErrors) {
            const errorDiv = document.getElementById('loginError');
            const errorText = document.getElementById('loginErrorText');
            errorText.innerHTML = {!! json_encode($errors->first()) !!};
            errorDiv.classList.remove('hidden');
        }
    }

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

});

// ===== MODAL OPEN/CLOSE =====
function openLoginModal() {
    const modal = document.getElementById('loginModal');
    const content = document.getElementById('loginModalContent');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    void modal.offsetWidth;
    modal.style.opacity = '0';
    modal.style.transition = 'opacity 0.3s ease';
    content.style.transform = 'scale(0.92) translateY(20px)';
    content.style.opacity = '0';
    content.style.transition = 'transform 0.45s cubic-bezier(0.34,1.56,0.64,1), opacity 0.35s ease';
    setTimeout(() => {
        modal.style.opacity = '1';
        content.style.transform = 'scale(1) translateY(0)';
        content.style.opacity = '1';
    }, 10);
}

function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    const content = document.getElementById('loginModalContent');
    modal.style.opacity = '0';
    content.style.transform = 'scale(0.92) translateY(20px)';
    content.style.opacity = '0';
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }, 350);
}

function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLoginModal();
});
</script>
