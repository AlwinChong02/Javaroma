CREATE DATABASE javaroma_db CHARACTER SET utf8 COLLATE utf8_general_ci;

USE javaroma_db;

CREATE TABLE users (
  userID INT(5) AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(24) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password TEXT NOT NULL
);

CREATE TABLE feedback (
  feedbackID INT(5) AUTO_INCREMENT PRIMARY KEY,
  userID INT(5),
  description VARCHAR(255),
  ratings INT(1),
  date DATETIME
);

CREATE TABLE product (
  productID INT(5) AUTO_INCREMENT PRIMARY KEY,
  productName VARCHAR(100) NOT NULL,
  productDescription VARCHAR(255),
  productCategory VARCHAR(100),
  ingredients VARCHAR(255),
  imagePath VARCHAR(255),
  price DECIMAL(5,2)
);

CREATE TABLE orders (
  orderID INT(5) AUTO_INCREMENT PRIMARY KEY,
  userID INT(5),
  totalAmount DECIMAL(5,2),
  orderDate DATETIME
);

CREATE TABLE orderItems (
  orderItemsID INT(5) AUTO_INCREMENT PRIMARY KEY,
  orderID INT(5),
  productID INT(5),
  quantity INT(5),
  price DECIMAL(5,2),
  temperature VARCHAR(10) 
);

CREATE TABLE store(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    area TEXT,
    details TEXT,
    images TEXT
);