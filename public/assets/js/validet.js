document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.querySelector('.alert');

    if (alertBox) {
        const closeBtn = alertBox.querySelector('.close');

        closeBtn.addEventListener('click', function () {
            alertBox.classList.add('hide');
            setTimeout(() => alertBox.remove(), 400);
        });

        // 4 soniyadan keyin avtomatik yopilishi
        setTimeout(() => {
            if (alertBox) {
                alertBox.classList.add('hide');
                setTimeout(() => alertBox.remove(), 400);
            }
        }, 4000);
    }
});
