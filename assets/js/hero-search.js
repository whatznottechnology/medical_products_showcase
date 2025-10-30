// Smooth typing animation functionality for hero search
const searchInput = document.getElementById('searchInput');
const placeholder = document.getElementById('placeholder');

const searchTerms = [
    'Sterilization',
    'CSSD Equipment',
    'Medical Devices',
    'Hospital Supplies',
    'Infection Control',
    'Surgical Instruments'
];

let currentIndex = 0;
let isTyping = false;

function typeText(element, text, callback) {
    if (isTyping) return;
    isTyping = true;

    element.textContent = '';
    element.className = 'text-yellow-500 font-semibold typing-animation';

    let i = 0;
    const typingSpeed = 100;

    function typeNextChar() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(typeNextChar, typingSpeed);
        } else {
            element.className = 'text-yellow-500 font-semibold';
            isTyping = false;
            if (callback) callback();
        }
    }

    typeNextChar();
}

function eraseText(element, callback) {
    if (isTyping) return;
    isTyping = true;

    const text = element.textContent;
    let i = text.length;
    const erasingSpeed = 50;

    function eraseNextChar() {
        if (i > 0) {
            element.textContent = text.substring(0, i - 1);
            i--;
            setTimeout(eraseNextChar, erasingSpeed);
        } else {
            isTyping = false;
            if (callback) callback();
        }
    }

    eraseNextChar();
}

function startTypingAnimation() {
    const animatedSpan = placeholder.children[1];

    typeText(animatedSpan, searchTerms[currentIndex], () => {
        setTimeout(() => {
            eraseText(animatedSpan, () => {
                currentIndex = (currentIndex + 1) % searchTerms.length;
                setTimeout(startTypingAnimation, 500);
            });
        }, 2000);
    });
}

// Search input event handlers
if (searchInput && placeholder) {
    searchInput.addEventListener('focus', () => {
        placeholder.style.display = 'none';
    });

    searchInput.addEventListener('blur', () => {
        if (searchInput.value === '') {
            placeholder.style.display = 'block';
        }
    });

    searchInput.addEventListener('input', () => {
        if (searchInput.value !== '') {
            placeholder.style.display = 'none';
        } else {
            placeholder.style.display = 'block';
        }
    });

    // Initialize animations
    startTypingAnimation();
}
