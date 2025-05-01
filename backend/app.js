const express = require('express');
const nodemailer = require('nodemailer');
const mysql = require('mysql');

// Креирање на Express апликација
const app = express();
app.use(express.json());  // за обработка на JSON тела во барањата

// Конекција до базата на податоци
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'your_database'
});

// Поврзување со базата на податоци
db.connect((err) => {
    if (err) {
        console.log('Грешка при поврзување со базата на податоци: ', err);
    } else {
        console.log('Успешно поврзување со базата на податоци');
    }
});

// Конфигурација на Nodemailer (SMTP сервер)
const transporter = nodemailer.createTransport({
    service: 'gmail', // или користете ваш SMTP сервер
    auth: {
        user: 'your_email@gmail.com', // вашата email адреса
        pass: 'your_email_password'   // вашата password
    }
});

// Функција за испраќање email notifications
function sendEmailNotification(eventName) {
    // Преземање на email адресите на сите корисници
    db.query('SELECT email FROM users', (err, results) => {
        if (err) {
            console.log('Грешка при преземање на корисници: ', err);
            return;
        }

        // Испраќање на email на секој корисник
        results.forEach(user => {
            const mailOptions = {
                from: 'your_email@gmail.com',
                to: user.email,
                subject: `Нови настан: ${eventName}`,
                text: `Здраво, имаме нов настан: ${eventName}. Не заборавајте да учествувате!`
            };

            transporter.sendMail(mailOptions, (error, info) => {
                if (error) {
                    console.log('Грешка при испраќање на email: ', error);
                } else {
                    console.log('Email успешно испратен на: ', user.email);
                }
            });
        });
    });
}

// Патека за креирање на нов настан
app.post('/create-event', (req, res) => {
    const { eventName, eventDescription } = req.body;

    // Вметнување на нов настан во базата на податоци
    const query = 'INSERT INTO events (name, description) VALUES (?, ?)';
    db.query(query, [eventName, eventDescription], (err, result) => {
        if (err) {
            console.log('Грешка при додавање на настан: ', err);
            res.status(500).send('Грешка при создавање на настан');
        } else {
            console.log('Новиот настан е успешно додаден!');
            sendEmailNotification(eventName);  // Повикај ја функцијата за испраќање email
            res.status(200).send('Настанот е успешно креиран!');
        }
    });
});

// Покренување на серверот
const port = 3000;
app.listen(port, () => {
    console.log(`Серверот работи на порт ${port}`);
});
