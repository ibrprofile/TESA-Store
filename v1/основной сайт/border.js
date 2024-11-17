document.addEventListener('DOMContentLoaded', function () {
    const borderRadiusToggle = document.getElementById('border-radius-toggle');
    const box = document.querySelector('.box');

    // Функция для изменения border-radius на основе значения ползунка
    borderRadiusToggle.addEventListener('input', function () {
        const borderRadiusValue = borderRadiusToggle.value;
        box.style.borderRadius = borderRadiusValue + 'px';
    });
});
