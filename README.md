# ServerA1

Team Members:
Muyang Li
Conrad Christian

Things to do:

- Reading a file / Changing file extension after upload
- CRUD for transaction and bucket tables
- Deploy Azure
- Add Admin User
-

Muyang

- login, signup done
- adding users database logic done
- admin view users done
- admin gives aprove premission to users done
- logout done
- admin connect to the buckets

Conrad - DB Backend

### Project Dependency
 - w2ui as ui and js framework to use, imported in header file
 - jQuery imported in header file
 - main css style setting and color themes are in src/style/main.css

### Users DB Usage

- admin account login by email: aa@aa.aa, password:     
- Clear current cookie in inspect - Application - cookies

### Assignment Details

Requirements
• There must be a feature that allows the user to import any file with the same format. Once a file is uploaded, it is renamed to with an extra extension of .imported
• Add, edit, and delete capability of bank transactions.
• Add, edit, and delete of bucket data.
• A registration page that allows users to register with their email and password.
• To login, a registered user has to be approved by the adminstrator.
• The admin username and password must be set to aa@aa.aa and P@$$w0rd
• Users must be authenticated to access any page. The only exceptions are the register & login pages.
• You will deploy your application to Azure.
• Put the name and team members in the footer on the home page of your application.

Submission
• Do not include unnecessary files that are not needed in your submission.
• Put the following information into the learning-hub (D2L) as you upload your solution:
o The URL of your app deployed to Azure.
o your names, BCIT ID numbers and your preferred email addresses. Avoid your my.bcit.ca email account because it has file attachment restrictions. This is necessary in case the assignment marker wishes to urgently contact you.
o what you have NOT completed
o any major challenges
o any special instructions for testing your web app.
• Assignments must be zipped (.zip extension) and uploaded to the drop-box folder for Assignment 1 in D2L (Learning Hub). Do not use any compression utility other than zip.
• Your ZIP file will include all directories and files comprising your entire web app.
• Each team must make only one submission. If you make more than one submission then you should use the same file name and clearly version the file by adding \_v2, \_v3, etc

### some common customed methods that we can user:

#### js method: window.popup1(title, content);

This is a pop up ui method imported in header.php line13 - 24, call it to open a pop up message box.
It will close after user click outside of the box
title: String
content String
usage: wrap it in $(function() {}) to execute after jQuery ready

### Bug Report
