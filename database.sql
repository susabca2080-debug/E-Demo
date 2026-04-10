CREATE DATABASE IF NOT EXISTS ecommerce_practice;

USE ecommerce_practice;

CREATE TABLE IF NOT EXISTS users (
	id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,
	phone VARCHAR(30) NOT NULL,
	address VARCHAR(255) NOT NULL,
	user_role VARCHAR(20) NOT NULL DEFAULT 'user',
	PRIMARY KEY (id),
	UNIQUE KEY email (email),
	UNIQUE KEY phone (phone)
);

CREATE TABLE IF NOT EXISTS product (x
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	description TEXT NOT NULL,
	price DECIMAL(10,2) NOT NULL,
	quantity INT NOT NULL,
	image VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS carts (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	product_id INT NOT NULL,
	product_image VARCHAR(255) NOT NULL,
	product_name VARCHAR(255) NOT NULL,
	product_price DECIMAL(10,2) NOT NULL,
	quantity INT NOT NULL DEFAULT 1,
	PRIMARY KEY (id),
	UNIQUE KEY user_product (user_id, product_id)
);

INSERT INTO users (email, pass, name, phone, address, user_role)
VALUES ('admin@example.com', 'admin123', 'Admin', '0000000000', 'Admin Address', 'admin');
