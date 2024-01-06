  window.onload = function() {
    // Проверить наличие сохраненных данных
    if (localStorage.getItem('formData')) {
      // Получить сохраненные данные из хранилища
      var formData = JSON.parse(localStorage.getItem('formData'));
  
      // Заполнить поля формы
      document.getElementById('mail').value = formData.mail;
      document.getElementById('login').value = formData.login;
      document.getElementById('password_a').value = formData.password_a;
      document.getElementById('password_c').value = formData.password_c;
      document.getElementById('FIO').value = formData.FIO;
    }
  };
  
  function validateForm() {
    // Получаем значения полей формы
    var mail = document.getElementById('mail').value;
    var login = document.getElementById('login').value;
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
  
    if (login.length < 5) {
      alert('Минимальная длина логина должна быть 5 символов');
      return false;
    }
  
    // Проверяем длину пароля
    if (password_a.length < 7) {
      alert('Пароль должен содержать не менее 8 символов');
      return false;
    }
  
    // Проверяем соответствие паролей
    if (password_a !== password_c) {
      alert('Пароли не совпадают');
      return false;
    }
  
    // Проверяем поле ФИО на ввод только символов
    const regex = /^[a-zA-Zа-яА-ЯёЁ\s-]+$/;
    if (!regex.test(FIO)) {
      alert('Поле ФИО должно содержать только символы!');
      return false;
    }
  
    if (!allowedExtensions.exec(fileName)) {
      alert('Разрешены только файлы с расширениями PNG и JPG.');
      // Очистить значение поля выбора файла
      fileInput.value = "";
      return false;
    }
  
    // Создать объект для сохранения данных
    var formData = {
      mail: mail,
      login: login,
      password_a: password_a,
      password_c: password_c,
      FIO: FIO
    };
    password_c
    // Сохранить данные в локальное хранилище
    localStorage.setItem('formData', JSON.stringify(formData));
  
    // Продолжить отправку формы
    return true; // Отправляем форму, если все проверки пройдены
  }
  
  function openModal() {
    document.getElementById('RegModal').style.display = 'none';
    document.getElementById('RecModal').style.display = 'none';
    document.getElementById('loginModal').style.display = 'block';
  }
  
  function closeModal() {
    document.getElementById('loginModal').style.display = 'none';
  }
  
  function openModalR() {
    document.getElementById('RecModal').style.display = 'none';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('RegModal').style.display = 'block';
  }
  
  function closeModalR() {
    document.getElementById('RegModal').style.display = 'none';
  }

  function openModalRec() {
    document.getElementById('RecModal').style.display = 'block';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('RegModal').style.display = 'none';
  }
  
  function closeModalRec() {
    document.getElementById('RecModal').style.display = 'none';
  }
  