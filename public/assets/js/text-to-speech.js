const metaLanguage = document.querySelector('meta[name="language"]');
const lang = metaLanguage.getAttribute('content');

const hoverTextElements = document.querySelectorAll('.speech-text');
// const hoverTextElements = document.querySelectorAll('*');

const findVoiceInLocale = (lang) => {
    const availableVoices = speechSynthesis.getVoices();
    return availableVoices.find((voice) => voice.lang === lang);
};

const speakText = (text, speed) => {
    const speechUtterance = new SpeechSynthesisUtterance(text);
    // speechUtterance.voiceURI = 'Google Bahasa Indonesia';
    speechUtterance.rate = speed;
    speechUtterance.lang = lang;
    const desiredVoice = findVoiceInLocale(lang);
    if (desiredVoice) speechUtterance.voice = desiredVoice;
    speechSynthesis.speak(speechUtterance);
};

const handleMouseEnter = (event) => {
    const hoveredElement = event.target;
    const textSpeech = hoveredElement.textContent.trim();
    stopSpeech();
    speakText(textSpeech, 0.9);
};

const stopSpeech = () => {
    const speechSynthesisInstance = window.speechSynthesis;
    if(speechSynthesisInstance.speaking) {
        speechSynthesisInstance.cancel();
    }
};

const speakSelectedText = () => {
    const selectedText = window.getSelection().toString().trim();
    if (selectedText) {
        stopSpeech();
        speakText(selectedText, 0.9);
    }
};
// const handleMouseLeave = (event) => {
    // const speechSynthesisInstance = window.speechSynthesis;
    // if (speechSynthesisInstance.speaking) {
    //     speechSynthesisInstance.cancel();
    // }
// };

hoverTextElements.forEach((element) => {
    element.addEventListener('mouseenter', handleMouseEnter);
    // element.addEventListener('mouseleave', handleMouseLeave);
});

document.addEventListener('mouseup', speakSelectedText);

document.addEventListener('load', function(){
    setTimeout(() => {
        const textSpeech = 'Selamat datang di sistem terpadu ulala';
        stopSpeech();
        speakText(textSpeech, 0.9);
    }, 1000);
});