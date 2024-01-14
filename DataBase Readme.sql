-- Connect to database
docker exec -it products_db mysql -u admin -p


-- Select db
USE products_db;



CREATE TABLE products (
    ID int,
    Title varchar(255),
    Img varchar(255),
    Price float(5),
    Quantity int(10),
    User_username varchar(255)
);
ALTER TABLE products MODIFY COLUMN ID INT AUTO_INCREMENT PRIMARY KEY;
DESCRIBE products;



CREATE TABLE orders (
    ID int,
    Products TEXT,
    Total_price float(10,2),
    Status varchar(255)
);
ALTER TABLE orders MODIFY COLUMN ID INT AUTO_INCREMENT PRIMARY KEY;
DESCRIBE orders;