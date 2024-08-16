// เมื่อกดเลือกเมนู
function handleButtonClick(button) {
    // ซ่อนปุ่มหลังจากกดไปแล้ว
    var formButtons = button.parentNode.querySelectorAll('button');
    formButtons.forEach(function (formButton) {
        formButton.style.display = 'none';
    });
    // ดึงค่า value ของปุ่ม
    var buttonValue = button.value;
    // สร้าง XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('post', 'match.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // ส่วนของ callback function ที่เรียกเมื่อ request สำเร็จ
    xhr.onload = function () {
        if (xhr.status === 200) {
            // ทำการปรับปรุง UI หรือดำเนินการอื่น ๆ ที่ต้องการ
            console.log('Server responded with:', xhr.responseText);
        } else {
            // มีบางอย่างผิดพลาดเกิดขึ้น (server error, network error, etc.)
            console.error('Server responded with status:', xhr.status);
        }
    };
    // ส่งข้อมูลไปที่ match.php
    xhr.send(`match=${buttonValue}`);
}
function handleNoButtonClick(button) {
    // ดึงค่า value ของปุ่ม
    var buttonValue = button.value;
    // สร้าง XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('post', 'match.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // ส่วนของ callback function ที่เรียกเมื่อ request สำเร็จ
    xhr.onload = function () {
        if (xhr.status === 200) {
            // ทำการปรับปรุง UI หรือดำเนินการอื่น ๆ ที่ต้องการ
            console.log('Server responded with:', xhr.responseText);
        } else {
            // มีบางอย่างผิดพลาดเกิดขึ้น (server error, network error, etc.)
            console.error('Server responded with status:', xhr.status);
        }
    };
    // ส่งข้อมูลไปที่ match.php
    xhr.send(`noMatch=${buttonValue}`);
}
// เมื่อกดไม่เลือกเมนู
// เพิ่มฟังก์ชัน updateBreakfastMenu เพื่ออัพเดท HTML และสุ่มเมนูใหม่
function updateBreakfastMenu(newContent) {
    // หา element ที่ต้องการอัพเดท
    var breakfastMenuContainer = document.getElementById('breakfast-menu-container');
    // ลบ
    breakfastMenuContainer.innerHTML = '';
    // อัพเดท HTML ของ element
    breakfastMenuContainer.innerHTML = newContent;
    // สุ่มเมนูใหม่
    getRandomMenu();
}
// ฟังก์ชันอัพเดท HTML ของเมนูที่สุ่มมาใหม่
function updateRandomMenu(newContent) {
    // หา element ที่ต้องการอัพเดท
    var randomMenuContainer = document.getElementById('random-menu-container');
    // อัพเดท HTML ของ element
    randomMenuContainer.innerHTML = newContent;
}
// เรียกใช้ฟังก์ชันเมื่อกดปุ่ม "ไม่กิน"
document.getElementById('no-breakfast').addEventListener('click', function () {
    // ทำการส่งคำร้องขอไปยัง match.php เพื่อเปลี่ยนเมนู
    var xhr = new XMLHttpRequest();
    xhr.open('post', 'asset/breakfast.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // รับข้อมูลเมนูใหม่จาก match.php
            var newMenu = xhr.responseText;
            console.log(newMenu);
            // ทำการอัพเดท HTML ของเมนู
            updateBreakfastMenu(newMenu);
        } else {
            console.error('Server responded with status:', xhr.status);
        }
    };
    xhr.send('noMatch=breakfast');
});
document.getElementById('no-lunch').addEventListener('click', function () {
    // ทำการส่งคำร้องขอไปยัง match.php เพื่อเปลี่ยนเมนู
    var xhr = new XMLHttpRequest();
    xhr.open('post', 'asset/lunch.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // รับข้อมูลเมนูใหม่จาก match.php
            var newMenu = xhr.responseText;
            console.log(newMenu);
            // ทำการอัพเดท HTML ของเมนู
            updateLunchMenu(newMenu);
        } else {
            console.error('Server responded with status:', xhr.status);
        }
    };
    xhr.send('noMatch=lunch');
});
document.getElementById('no-dinner').addEventListener('click', function () {
    // ทำการส่งคำร้องขอไปยัง match.php เพื่อเปลี่ยนเมนู
    var xhr = new XMLHttpRequest();
    xhr.open('post', 'asset/dinner.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // รับข้อมูลเมนูใหม่จาก match.php
            var newMenu = xhr.responseText;
            console.log(newMenu);
            // ทำการอัพเดท HTML ของเมนู
            updateDinnerMenu(newMenu);
        } else {
            console.error('Server responded with status:', xhr.status);
        }
    };
    xhr.send('noMatch=dinner');
});
// ฟังก์ชันอัพเดท HTML ของเมนู
function updateBreakfastMenu(newContent) {
    // หา element ที่ต้องการอัพเดท
    var breakfastMenuContainer = document.getElementById('breakfast-menu-container');
    // อัพเดท HTML ของ element
    breakfastMenuContainer.innerHTML = newContent;
}
function updateLunchMenu(newContent) {
    // หา element ที่ต้องการอัพเดท
    var breakfastMenuContainer = document.getElementById('lunch-menu-container');
    // อัพเดท HTML ของ element
    breakfastMenuContainer.innerHTML = newContent;
}
function updateDinnerMenu(newContent) {
    // หา element ที่ต้องการอัพเดท
    var breakfastMenuContainer = document.getElementById('dinner-menu-container');
    // อัพเดท HTML ของ element
    breakfastMenuContainer.innerHTML = newContent;
}
// เรียกฟังก์ชัน handleButtonClick เมื่อปุ่ม กิน ถูกคลิก
document.querySelectorAll('.breakfast-button').forEach(function (button) {
    button.addEventListener('click', function () {
        // BButtonClick(button);
    });
});
document.querySelectorAll('.lunch-button').forEach(function (button) {
    button.addEventListener('click', function () {
        // LButtonClick(button);
    });
});
document.querySelectorAll('.dinner-button').forEach(function (button) {
    button.addEventListener('click', function () {
        // DButtonClick(button);
    });
});