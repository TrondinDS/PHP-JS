const books = [
  {
    id: 1,
    name: 'Банда четырех',
    number_pages: 446,
    year: 2022,
    autor: 'Гамма, Хелм, Джонсон, Влиссидес',
    gener: 'Тех.Лит.',
    format: 'Печатная книга',
    color: 'Высокая',
    screenBook: 'images/ZelBook.jpg',
    isAvailability: true,
  },
  {
    id: 2,
    name: 'Имя',
    number_pages: 100,
    year: 2000,
    autor: 'Иванов',
    gener: 'Фантастика',
    format: 'Аудио книга',
    color: 'Средняя',
    screenBook: 'images/GolBook.jpg',
    isAvailability: true,
  },
  {
    id: 3,
    name: 'Кома',
    number_pages: 100,
    year: 2000,
    autor: 'Иванов',
    gener: 'Гримдарк',
    format: 'Печатная книга',
    color: 'Низкая',
    screenBook: 'images/BleBook.jpg',
    isAvailability: true,
  },
];

const checkBoxs = [
  {
    Name: 'Жанр',
    listCheckBox: [
      {
        id: 1,
        value: 'Фантастика',
        category: 'gener',
      },
      {
        id: 2,
        value: 'Гримдарк',
        category: 'gener',
      },
      {
        id: 3,
        value: 'Тех.Лит.',
        category: 'gener',
      },
    ],
  },
  {
    Name: 'Формат',
    listCheckBox: [
      {
        id: 4,
        value: 'Аудио книга',
        category: 'format',
      },
      {
        id: 5,
        value: 'Электронная книга',
        category: 'format',
      },
      {
        id: 6,
        value: 'Печатная книга',
        category: 'format',
      },
    ],
  },
  {
    Name: 'Цвет',
    listCheckBox: [
      {
        id: 7,
        value: 'Низкая',
        category: 'color',
      },
      {
        id: 8,
        value: 'Средняя',
        category: 'color',
      },
      {
        id: 9,
        value: 'Высокая',
        category: 'color',
      },
    ],
  },
];

var ListBooks = [];



function filterBooks() {
  const selectedCheckboxes = [];

  const selectedValues = checkBoxs.map(checkBox => {
    const checkedValues = Array.from(document.querySelectorAll(`input[name="${checkBox.listCheckBox[0].category}"]:checked`)).map(checkbox => {
      selectedCheckboxes.push(checkbox); // Добавляем выделенные чекбоксы в массив
      return checkbox.value;
    });
    return { category: checkBox.listCheckBox[0].category, values: checkedValues };
  });

  const filteredBooks = books.filter(book => {
    return selectedValues.every(({ category, values }) => {
      return values.length === 0 || values.includes(book[category.toLowerCase()]);
    });
  });

  if (filteredBooks.length > 0) {
    filterBooksCHB();
    printBlockBooks(filteredBooks);
    ListBooks = filteredBooks;
  } else {
    selectedCheckboxes.forEach(checkbox => {
      checkbox.checked = true;
    });
  }
}

function filterBooks(lastClickedCheckboxId) {
  const selectedCheckboxes = [];

  const selectedValues = checkBoxs.map(checkBox => {
    const checkedValues = Array.from(document.querySelectorAll(`input[name="${checkBox.listCheckBox[0].category}"]:checked`)).map(checkbox => {
      selectedCheckboxes.push(checkbox); // Добавляем выделенные чекбоксы в массив
      return checkbox.value;
    });
    return { category: checkBox.listCheckBox[0].category, values: checkedValues };
  });

  const filteredBooks = books.filter(book => {
    return selectedValues.every(({ category, values }) => {
      return values.length === 0 || values.includes(book[category.toLowerCase()]);
    });
  });

  if (filteredBooks.length > 0) {
    ListBooks = filteredBooks;
    filterBooksCHB();
    printBlockBooks(filteredBooks);
  } else {
    document.getElementById(lastClickedCheckboxId).checked = true;
    alert('Снятие данной галочки приведет к пустому списку. В доступе отказанно.');
  }
}

// Вывод категорий фильтра в HTML
function PrintCheckBox() {
  var checkBoxList = document.getElementById('checkBoxList');
  let checkBoxesHtml = '';

  checkBoxs.forEach(checkBox => {
    checkBoxesHtml += `<div class="checkBoxDiv_Colum">`;
    checkBox.listCheckBox.forEach(box =>
      checkBoxesHtml += `<div><input onchange="filterBooks('${box.id}')" type="checkbox" id="${box.id}" name="${box.category}" value="${box.value}">${box.value}</div>`
    );
    checkBoxesHtml += `</div>`;
  });

  checkBoxList.innerHTML = checkBoxesHtml;
  filterBooks(); // Применяем фильтрацию после установки разметки чекбоксов

}

function addListParam() {
  // Получаем все элементы чекбоксов на странице
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');

  // Создаем пустой массив для хранения отмеченных чекбоксов
  const checkedCheckboxes = [];

  // Проходимся по всем чекбоксам и добавляем в массив только те, которые отмечены
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      checkedCheckboxes.push(checkbox);
    }
  });

  // В результате в массиве checkedCheckboxes будут только значения отмеченных чекбоксов
  console.log(checkedCheckboxes);
  return checkedCheckboxes;
}

function addListParamN() {
  // Получаем все элементы чекбоксов на странице
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');

  // Создаем пустой массив для хранения отмеченных чекбоксов
  const checkedCheckboxes = [];

  // Проходимся по всем чекбоксам и добавляем в массив только те, которые не отмечены
  checkboxes.forEach((checkbox) => {
    if (!checkbox.checked) {
      checkedCheckboxes.push(checkbox);
    }
  });

  // В результате в массиве checkedCheckboxes будут только значения отмеченных чекбоксов
  console.log(checkedCheckboxes);
  return checkedCheckboxes;
}

//проверяем звблокирует ли выбор данного чекбокса какие либо параметры
function forCBFilt() {
  const CBN = addListParamN();
  CBN.forEach((element) => {
    var CheckBox = checkBoxValueCheck(element);
    if (CheckBox.length == 0) //izm
    {
      element.disabled = true;
    }
    else {
      element.disabled = false;
    }
    if (deepArrayComparison(CheckBox, ListBooks)) {
      element.disabled = true;
    }
  })
}

//Алгоритм сравнения массивов
function deepArrayComparison(arr1, arr2) {
  // Проверка длины массивов
  if (arr1.length !== arr2.length) {
    return false;
  }

  // Рекурсивное сравнение элементов массивов
  for (let i = 0; i < arr1.length; i++) {
    const val1 = arr1[i];
    const val2 = arr2[i];

    // Проверка типов элементов
    if (typeof val1 !== typeof val2) {
      return false;
    }

    // Рекурсивное сравнение значений
    if (Array.isArray(val1) && Array.isArray(val2)) {
      // Если элементы - массивы, вызываем глубокое сравнение для них
      if (!deepArrayComparison(val1, val2)) {
        return false;
      }
    } else if (val1 !== val2) {
      // Если элементы не массивы, проверяем их равенство
      return false;
    }
  }

  // Все элементы равны
  return true;
}

//создание тестового списка для того что-бы понять норм чекбокс или надо блокать
function checkBoxValueCheck(element) {
  const selectedValues = checkBoxs.map(checkBox => {
    const checkedValues = Array.from(document.querySelectorAll(`input[name="${checkBox.listCheckBox[0].category}"]:checked`)).map(checkbox => checkbox.value);
    return { category: checkBox.listCheckBox[0].category, values: checkedValues };
  });

  if (element) {
    const category = element.getAttribute('name');
    const value = element.value;
    const existingCategory = selectedValues.find(item => item.category === category);

    if (existingCategory) {
      existingCategory.values.push(value);
    } else {
      const newElement = { category, values: [value] };
      selectedValues.push(newElement);
    }
  }

  const filteredBooks = books.filter(book => {
    return selectedValues.every(({ category, values }) => {
      return values.length === 0 || values.includes(book[category.toLowerCase()]);
    });
  });

  return filteredBooks;
}

function filterBooksCHB() {
  forCBFilt();
  // Получаем выбранные параметры из метода addListParam()
  const checkedCheckboxes = addListParam();
  // Фильтруем массив books по выбранным параметрам
  const filteredBooks = books.filter((book) => {
    // Проверяем, есть ли у книги все выбранные параметры
    return checkedCheckboxes.every((checkbox) => {
      return book[checkbox.name].includes(checkbox.value);
    });
  });
  // Возвращаем отфильтрованный массив книг
  console.log(filteredBooks);
}

// Вывод отфильтрованных книг в HTML
function printBlockBooks(filteredBooks) {
  const bookList = document.getElementById('nameList');
  let booksHtml = '';

  filteredBooks.forEach(book => {
    booksHtml += `<div class="book">
                    <div class = "bookimg">
                      <img class="img" src="${book.screenBook}" alt="image">
                    </div>
                    <div class = "book-tetxt">
                      <h2 class = "text-h2-cemter text-size-h2">${book.name}</h2>
                      <p class = "text-size-text">Популярность: ${book.color}</p>
                      <p class = "text-size-text">Жанр: ${book.gener}</p>
                      <p class = "text-size-text">Вариант: ${book.format}</p>
                    </div>
                  </div>`;
  });

  bookList.innerHTML = booksHtml;
}



