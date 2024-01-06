function validateForm() {
    // Получаем значения полей формы
    var mail = document.getElementById('mail').value;
    var password_a = document.getElementById('password_a').value;
    var password_c = document.getElementById('password_c').value;
    var FIO = document.getElementById('FIO').value;
    var fileInput = document.querySelector('input[type="file"]');
    var fileName = fileInput.value;
    var allowedExtensions = /(\.png|\.jpg)$/i;

    // Проверяем валидность поля почты
    var emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    if (!mail.match(emailRegex)) {
        alert('Некорректный адрес электронной почты');
        return false;
    }

    // Проверяем длину пароля только если поле пароля не пусто
    if (password_a.trim() !== '') {
        if (password_a.length < 8) {
            alert('Пароль должен содержать не менее 8 символов');
            return false;
        }

        // Проверяем соответствие паролей
        if (password_a !== password_c) {
            alert('Пароли не совпадают');
            return false;
        }
    }

    // Проверяем поле ФИО на ввод только символов
    const regex = /^[a-zA-Zа-яА-ЯёЁ\s-]+$/;
    if (!regex.test(FIO)) {
        alert('Поле ФИО должно содержать только символы!');
        return false;
    }

    // Проверяем разрешенные расширения файлов только если поле выбора файла не пусто
    if (fileName.trim() !== '') {
        if (!allowedExtensions.exec(fileName)) {
            alert('Разрешены только файлы с расширениями PNG и JPG.');
            // Очистить значение поля выбора файла
            fileInput.value = "";
            return false;
        }
    }
}