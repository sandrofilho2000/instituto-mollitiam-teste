# 📘 CodeIgniter Grades and Report Cards

This project is an application built with CodeIgniter, jQuery, and Bootstrap that allows you to manage subjects and students. Each registered subject becomes a column in the student table, where individual grades can be assigned. The application also generates PDF report cards for each student using the DPDF library.

🚀 Features
-----------

* Subject registration
* Student registration
* Grade assignment for students
* PDF report card generation

> [!NOTE]
> The system was developed using CodeIgniter as the main framework, ensuring lightness and performance.

## 🛠️ Technologies Used

* **CodeIgniter** : PHP framework for rapid development
* **jQuery** : Dynamic manipulation of front-end elements
* **Bootstrap** : Styling and responsive interface
* **DPDF** : PDF document generation for report cards

## 📷 Screenshots

| Students Page                                                                           | Subjects Page                                                                           | Report Card                                                                             |
| --------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| ![image](https://github.com/user-attachments/assets/b81c3959-60a8-40c1-83a2-eb671ca24dc1) | ![image](https://github.com/user-attachments/assets/a3431c5e-8e24-4308-b6f2-476cd1159734) | ![image](https://github.com/user-attachments/assets/ae57d1e1-9a53-473a-80e8-5b3716f844d4) |

## 🔧 Installation

<ul>
  <li>
    Clone the repository:
  </li>
</ul>

```sh
 git clone https://github.com/sandrofilho2000/instituto-mollitiam
```

<ul>
    <li>Configure the database in <code>app/config/database.php</code>.</li>
</ul>
<ul>
  <li>
    Run the migrations to create the tables:
  </li>
</ul>

```sh
   php spark migrate
```

<ul>
  <li>
    Start the local server:
  </li>
</ul>


```sh
php spark serve
```

<ul>
  <li>
    Acesse http://localhost:8080 no navegador.
  </li>
</ul>

> [!WARNING]
> Tables must be correctly migrated before using the application.

## 📄 Report Card Generation

Report cards in PDF format are generated using the DPDF library. Each report card contains:

* Student’s name
* Subjects and grades
* Final average

> [!CAUTION]
> The generated PDF is based on the registered grades. Make sure all subjects have been filled out before generating the report card.

## 📂 Project Structure

```
codeigniter-notas/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Config/
├── public/
├── writable/
└── database.sql
```
