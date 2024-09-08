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


INSERT INTO `product`(`productName`, `productDescription`, `productCategory`, `ingredients`, `imagePath`, `price`) VALUES 
('Matcha Maven','Savor the vivid embrace of Matcha Maven, a skillfully made matcha latte that combines the contemporary flare of artisanal coffee culture with the age-old Japanese tea ceremony','Kuching Meow','Dairy Milk, Cham, Kuching Meow Matcha','../images/drinks/Matcha Maven.png','15.90'),
('Hazel Harmony', 'With its rich, roasted scent and smooth flavor, Hazel Harmony is a hojicha latte that transports you to a world of warmth and coziness. Hojicha, a drink made from roasted green tea leaves, has a rich, earthy flavor with hints of caramel and hazelnut that combine to create a very harmonious and distinctive cup.','Kuching Meow','Dairy Milk, Hazelnut, Cham, Kuching Meow Hojicha', '../images/drinks/Hazel Harmony.png','15.90'),
('Mamak Magic', 'Mamak Magic is an experience that takes you to the busy streets of Malaysia, where families and friends come to eat their favorite mamak dishes. It’s more than simply a drink. The creamy milk flavor along with the deep amber hue of the tea embodies the coziness and coziness that define mamak culture.','Kuching Meow','Dairy Milk, Cham, Kuching Meow Milk Tea', '../images/drinks/Mamak Magic.png','15.90'),
('Blue Velvet', 'The flowery, somewhat earthy flavors of blue velvet perfectly balance the creamy richness of milk to create a velvety smooth latte that relaxes and delights the palate. Blue velvet is more than simply a visual feast. As the milk and deep blue tea swirl together, creating a captivating ombre effect that entices you to savor every sip, the magic begins to happen.','Kuching Meow','Dairy Milk, Cham, Vanilla Extract, Kuching Meow Butterfly Pea Flowers', '../images/drinks/Blue Velvet.png','15.90'),
('Americano', 'A shot of Espresso with a deep-tan crema that’s smooth and robust and perfectly preserved for your enjoyment.', 'Coffee', 'Espresso', '../images/drinks/Americano.png', '6.90'),
('Australian Chocolate', 'A rich & chocolatey experience made with Australian Cocoa, that’s beautifully balanced between the dark & light milky flavour.', 'Non-Coffee', 'Milk, Cocoa', '../images/drinks/Australian Chocolate.png', '12.90'),
('Cappuccino', 'Like drinking delicious coffee bubbles, for those who enjoy it extra foamy. With lesser milk & more foam, if you like your coffee strong, the Cappuccino is the way to go.', 'Coffee', 'Espresso, Milk', '../images/drinks/Cappuccino.png', '9.90'),
('Caramel Cream Frappe', 'Specially made for our sweet coffee lovers! Imagine drinking your favourite caramel toffee dessert in an ice-blended fashion, yum!', 'Frappé', 'Milk, Caramel syrup', '../images/drinks/Caramel Cream Frappe.png', '14.90'),
('Caramel Macchiato', 'A rich blend of espresso and velvety steamed milk topped with a caramel drizzle.', 'Coffee', 'Espresso, Milk, Caramel Syrup', '../images/drinks/Caramel Macchiato.png', '11.90'),
('Cocoa Mocha Frappé', 'Rich mocha blended with ice and topped with whipped cream and a mocha drizzle.', 'Frappé', 'Espresso, Cocoa, Milk', '../images/drinks/Cocoa Mocha Frappé.png', '14.90'),
('Creamy Mango', 'A creamy, tropical delight made with fresh mango puree.', 'Non-Coffee', 'Mango, Peach, Milk', '../images/drinks/Creamy Mango.png', '9.90'),
('Espresso Frappe', 'A bold shot of espresso blended with ice and topped with whipped cream.', 'Frappé', 'Espresso, Milk, Vanilla Syrup', '../images/drinks/Espresso Frappe.png', '14.90'),
('French Vanilla Chocolate', 'A rich and creamy chocolate experience with a hint of French vanilla.', 'Non-Coffee', 'Milk, Cocoa, Vanilla Syrup', '../images/drinks/French Vanilla Chocolate.png', '12.90'),
('Cafe Mocha', 'This mixture of chocolate & coffee has won the hearts of many. For rich dessert lovers. Crafted with 100% Australian Chocolate (40% Cocoa).', 'Coffee', 'Espresso, Chocolate, Milk', '../images/drinks/Iced Cafe Mocha.png', '12.90'),
('Coconut Latte', 'This coco loco sensation has it all –it’s cool, it’s fresh, and it’s downright addictive! Crafted especially for hot and humid weather, this coffee offers a delightful coconutty flavour, enriched with a secret blend. It’s the perfect way to beat the heat and treat your taste buds to an extraordinary experience.', 'Coffee', 'Sweet Milk, Textured Milk, Barista Coconut Milk, Espresso', '../images/drinks/Iced Coconut Latte.png', '10.90'),
('Latte', 'For those who enjoy their coffee on the milky side. Milk is frothed between temperatures of 69-72ºC, optimum to a Barista’s touch and akin to the temperature that is suitable for our customers to drink immediately upon serving.', 'Coffee', 'Espresso, Milk', '../images/drinks/Iced Latte.png', '9.90'),
('Japanese Matcha Frappé', 'A refreshing blend of Japanese matcha and ice.', 'Frappé', 'Matcha, Milk', '../images/drinks/Japanese Matcha Frappé.png', '14.90'),
('Java Chip Frappé', 'A rich blend of coffee, chocolate chips, and ice.', 'Frappé', 'Espresso, Chocolate Chips, Milk', '../images/drinks/Java Chip Frappé.png', '14.90'),
('Matcho Latté', 'A smooth and creamy matcha latte.', 'Non-Coffee', 'Milk, Green Tea Powder, Catcher - Chocolate Sauce', '../images/drinks/Matcho Latté.png', '9.90'),
('Roasted Hazelnut Chocolate', 'A rich hazelnut-flavored chocolate drink.', 'Non-Coffee', 'Hazelnut Syrup, Cocoa, Milk', '../images/drinks/Roasted Hazelnut Chocolate.png', '12.90'),
('Roasted Hazelnut Latte', 'A creamy latte with a hint of roasted hazelnut.', 'Coffee', 'Espresso, Milk, Hazelnut Syrup', '../images/drinks/Roasted Hazelnut Latte.png', '10.90'),
('Salted Caramel Chocolate', 'A deliciously rich salted caramel chocolate drink.', 'Non-Coffee', 'Milk, Cocoa, Salted Caramel Syrup', '../images/drinks/Salted Caramel Chocolate.png', '12.90'),
('Salted Caramel Frappé', 'A sweet and salty caramel frappé.', 'Frappé', 'Milk, Espresso, Salted Caramel Syrup', '../images/drinks/Salted Caramel Frappé.png', '14.90'),
('Spanish Latte', 'A rich and creamy latte with a hint of Spanish flavor.', 'Coffee', 'Espresso, Sweet Milk, Textured Milk, Full Cream Milk', '../images/drinks/Spanish Latte.png', '10.90'),
('Vietnamese Spanish Latte', 'A sweet and creamy Vietnamese-style Spanish latte.', 'Coffee', 'Sweet Milk, Textured Milk, Milk, Vietnamese Coffee Base, Coconut Cream', '../images/drinks/Vietnamese Spanish Latte.png', '10.90'),
('Zero Frappe', 'A sugar-free frappé with a creamy texture.', 'Frappé', 'Espresso, Oat, Almond, Soy, Vanilla Powder', '../images/drinks/Zero Frappe.png', '14.90'),
('Javaroma Lemonade', 'A refreshing lemonade made with fresh lemons.', 'Non-Coffee', 'Lemon, Honey, Soda Water', '../images/drinks/Javaroma Lemonade.png', '7.90');



INSERT INTO store (name, area, details, images) 
VALUES('JavaRoma - HQ', 'Selangor', 'No 20, Ground Floor, Jalan SL 1/4, Bandar Sungai Long, 43000 Kajang, Selangor' ,'../images/SelangorBranch.png'),
('JavaRoma', 'Penang', 'Lot 10, Maritime, Karpal Singh Dr, 11600 Jelutong, Penang', '../images/PenangBranch.png'),
('JavaRoma', 'Melaka', 'No 43, Ground Floor, Jalan Mutiara Melaka 2, Taman Mutiara Melaka, Batu Berendam, 75350 Hang Tuah Jaya, Melaka', '../images/MelakaBranch.png'),
('JavaRoma', 'Johor', 'No 22(GF) Jalan Pulai Mutiara 9/6, Taman Pulai Mutiara, 81300 Johor Bahru, Johor.', '../images/JohorBranch.png'),
('JavaRoma', 'Sarawak', 'Lot 789, Block 5, Ground Floor, Sibu Town District, 29 Jalan Lau King Howe, 96000, Sibu, Sarawak', '../images/SarawakBranch.png');