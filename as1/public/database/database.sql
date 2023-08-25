-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;
-- Drop tables if they exist
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `auctions`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `bids`;

-- Create the users table
CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `FirstName` VARCHAR(20) DEFAULT NULL,
  `LastName` VARCHAR(20) DEFAULT NULL,
  `DOB` DATE DEFAULT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(255) NOT NULL -- Increase the length here
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Insert data into the users table
INSERT INTO `users` (`FirstName`, `LastName`, `DOB`, `Email`, `Password`) VALUES
('Arun',	'rai',	'2001-06-18',	'arun9@gmail.com',	'89e7463b9d2ccb1d165fskknfdksnffgsfb49dcf'),
('Jumsu',	'lama',	'2002-02-11',	'lama34@gmail.com',	'd66327f6d12ef8676c454022c26739ccd546cc79'),
('Riya',	'Shrestha',	'2013-01-04',	'shrestha08@gmail.com',	'52cdc16cb8a04d369e5e4cbds1d41fa704'),
('Supriya',	'Joshi',	'2003-01-19',	'joshu7@gmail.com',	'96c7dd03cded7224cf9d4c766854ba38b050e080'),
('kedar',	'Lama',	'2022-02-10',	'lama@gmail.com',	'b9d9cff0706d52fb1a8938117691b34661eed2e8'),
('karshav',	'gimire',	'2000-06-12',	'kndks@gmail.com',	'8aa5acc8c6a261gkskknfdkdfneda289d1759f59'),
('Anthony',	'Yorkster',	'2002-05-16',	'dfsdf@gmail.com',	'01e8906a38c867853c9nfrnsknfkndfsdb6aa06'),
('RAY',	'park',	'2004-04-11',	'parj4@gmail.com',	'6c44ae31dde4a32rfggfsfds0c161e2cbcf507dfeb'),
('Landon',	'Johnas',	'2010-08-13',	'johnas36@gmail.com',	'd57ccb6da98c2adabb52b9bdfnsndfsndfe093da4');


-- Create the categories table
CREATE TABLE `categories` (
  `categoryName` VARCHAR(20) NOT NULL PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the categories table
INSERT INTO `categories` (`categoryName`) VALUES
('Home & Garden'), ('Charity'), ('AutoMobiles'), ('Motors'), ('Antiques'),
('Art'), ('Books'), ('Sports'), ('Technology'),('Jewelry'),
('Fashion'), ('Health'), ('Toys'), ('Collectibles'), ('Beverages');

-- Create the auctions table with categoryID column
CREATE TABLE `auctions` (
  `auction_name` VARCHAR(90) NOT NULL PRIMARY KEY,
  `auctioneer` VARCHAR(90) DEFAULT NULL,
  `auctionDate` DATE DEFAULT NULL,
  `auction_end_time` TIMESTAMP DEFAULT NULL, -- Add the new column for auction end time
  `categoryName` VARCHAR(20) DEFAULT NULL,
  `Description` LONGTEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the auctions table
INSERT INTO `auctions` (`auction_name`, `auctioneer`, `auctionDate`, `auction_end_time`, `categoryName`, `Description`) VALUES
('Art Auction', 'James', '2023-05-14', '2023-03-15 17:59:00', 'Art', 'Art Auction featuring a diverse collection of modern and contemporary artworks'),
('Charity Auction', 'Earny', '2023-08-18', '2023-03-10 17:59:00', 'Charity', 'Charity Auction to support local community projects and initiatives'),
('Vintage Car Auction', 'Michelle', '2023-04-18', '2023-03-18 17:59:00', 'AutoMobiles', 'Vintage Car Auction showcasing classic cars from different eras'),
('Antique Furniture Auction', 'Susane', '2023-04-22', '2023-03-20 17:59:00', 'Antiques', 'Antique Furniture Auction presenting a wide range of exquisite antique pieces'),
('Jewelry Auction', 'Jeremaya', '2023-04-18', '2023-03-12 17:59:00', 'Jewelry', 'Jewelry Auction featuring a dazzling collection of rings, necklaces, and more'),
('Wine Auction', 'Willow', '2023-03-30', '2023-03-25 17:59:00', 'Beverages', 'Wine Auction offering a curated selection of fine wines and vintages'),
('Rare Book Auction', 'Alexa', '2023-04-18', '2023-03-16 17:59:00', 'Books', 'Rare Book Auction with a focus on unique and collectible literary works'),
('Sports Memorabilia Auction', 'Ryan', '2023-05-14', '2023-03-14 17:59:00', 'Sports', 'Sports Memorabilia Auction featuring autographed jerseys, equipment, and more'),
('Tech Gadgets Auction', 'Sophia', '2023-06-22', '2023-03-22 17:59:00', 'Technology', 'Tech Gadgets Auction showcasing the latest electronic devices and gadgets'),
('Fashion Auction', 'Olive', '2023-06-21', '2023-03-11 17:59:00', 'Fashion', 'Fashion Auction highlighting designer clothing, accessories, and runway pieces'),
('Coin and Currency Auction', 'Daniella', '2023-08-27', '2023-03-17 17:59:00', 'Collectibles', 'Coin and Currency Auction featuring rare coins, banknotes, and numismatic items'),
('Domestic Auction', 'Donna', '2023-03-17', '2023-05-27 17:59:00', 'Home & Garden', 'Coin and Currency Auction featuring rare coins, banknotes, and numismatic items');

-- Update data in the auctions table with correct category IDs and end times
UPDATE `auctions` SET `categoryName` = 'Art', `auction_end_time` = '2023-03-15 17:59:00' WHERE `auction_name` = 'Art Auction';
UPDATE `auctions` SET `categoryName` = 'Charity', `auction_end_time` = '2023-03-10 17:59:00' WHERE `auction_name` = 'Charity Auction';
UPDATE `auctions` SET `categoryName` = 'AutoMobiles', `auction_end_time` = '2023-03-18 17:59:00' WHERE `auction_name` = 'Vintage Car Auction';
UPDATE `auctions` SET `categoryName` = 'Antiques', `auction_end_time` = '2023-03-20 17:59:00' WHERE `auction_name` = 'Antique Furniture Auction';
UPDATE `auctions` SET `categoryName` = 'Jewelry', `auction_end_time` = '2023-03-12 17:59:00' WHERE `auction_name` = 'Jewelry Auction';
UPDATE `auctions` SET `categoryName` = 'Beverages', `auction_end_time` = '2023-03-25 17:59:00' WHERE `auction_name` = 'Wine Auction';
UPDATE `auctions` SET `categoryName` = 'Books', `auction_end_time` = '2023-03-16 17:59:00' WHERE `auction_name` = 'Rare Book Auction';
UPDATE `auctions` SET `categoryName` = 'Sports', `auction_end_time` = '2023-03-14 17:59:00' WHERE `auction_name` = 'Sports Memorabilia Auction';
UPDATE `auctions` SET `categoryName` = 'Technology', `auction_end_time` = '2023-03-22 17:59:00' WHERE `auction_name` = 'Tech Gadgets Auction';
UPDATE `auctions` SET `categoryName` = 'Fashion', `auction_end_time` = '2023-03-11 17:59:00' WHERE `auction_name` = 'Fashion Auction';
UPDATE `auctions` SET `categoryName` = 'Collectibles', `auction_end_time` = '2023-03-17 17:59:00' WHERE `auction_name` = 'Coin and Currency Auction';
-- ... (other auction updates if needed)


-- Add foreign key constraint
ALTER TABLE `auctions`
ADD CONSTRAINT `fk_auctions_category` FOREIGN KEY (`categoryName`) REFERENCES `categories` (`categoryName`);

-- Create the reviews table
CREATE TABLE `reviews` (
  `reviewId` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstName` VARCHAR(50) DEFAULT NULL,
  `LastName` VARCHAR(50) DEFAULT NULL,
  `review_Date` VARCHAR(30) DEFAULT NULL,
  `review_Content` MEDIUMTEXT NOT NULL,
  `auction_name` VARCHAR(90) NOT NULL,
  `authorised` CHAR(1) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  FOREIGN KEY (`auction_name`) REFERENCES `auctions` (`auction_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the reviews table
INSERT INTO `reviews` (`reviewId`, `firstName`, `LastName`, `review_Date`, `review_Content`, `auction_name`, `authorised`, `email`) VALUES
(1, 'Arun', 'rai', '2023/03/15', ' Exciting event!', 'Art Auction', 'Y', 'rai@gmail.com'),
(2, 'kedar', 'lama', '2023/03/15', ' Can\'t wait!', 'Art Auction', 'Y', 'lama09@gmail.com'),
(3, 'Rabindra', 'harriet', '2023/03/16', ' Amazing initiative', 'Charity Auction', 'Y', 'harriet@gmail.com'),
(4, 'Rajendra', 'Yan', '2023/03/16', ' Let\'s support!', 'Charity Auction', 'Y', 'yan@gmail.com'),
(5, 'karshav', 'ghimire', '2023/03/14', ' Vintage cars are my passion!', 'Vintage Car Auction', 'Y', 'ghimirel@gmail.com'),
(6, 'Landon', 'Jonas', '2023/03/14', ' Exciting collection', 'Vintage Car Auction', 'Y', 'jonas8@gmail.com'),
(7, 'Supriya', 'Joshi', '2023/03/18', ' Love antique furniture!', 'Antique Furniture Auction', 'Y', 'joshi78@gmail.com'),
(8, 'Ray', 'Park', '2023/03/18', ' Can\'t wait to see them', 'Antique Furniture Auction', 'Y', 'park76@gmail.com'),
(9, 'Riya', 'Shrestha', '2023/11/18', ' Love vintage wines', 'Wine Auction ', 'Y', 'shrestharia08@gmail.com');

-- Add foreign key constraint for reviews table
ALTER TABLE `reviews`
ADD CONSTRAINT `fk_reviews_auction` FOREIGN KEY (`auction_name`) REFERENCES `auctions` (`auction_name`);

CREATE TABLE `bids` (
    `bidId` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `auction_name` VARCHAR(90) NOT NULL,
    `bidAmount` DECIMAL(10, 2) NOT NULL,
    `bidder_email` VARCHAR(50) NOT NULL,
    `bidTimestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`auction_name`) REFERENCES `auctions` (`auction_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the bids table
INSERT INTO `bids` (`auction_name`, `bidAmount`, `bidder_email`) VALUES
('Art Auction', 100.00, 'bidders_email@example.com'),
('Art Auction', 150.00, 'another_bidder@example.com'),
('Vintage Car Auction', 5000.00, 'carlover@email.com'),
('Vintage Car Auction', 5500.00, 'vintagecarfan@example.com'),
('Jewelry Auction', 200.00, 'jewelry_bidder@example.com'),
('Antique Furniture Auction', 300.00, 'antiqueslover@example.com'),
('Wine Auction', 50.00, 'winelover@example.com'),
('Tech Gadgets Auction', 250.00, 'techenthusiast@example.com'),
('Fashion Auction', 75.00, 'fashionista@example.com');

-- ... your existing tables and data ...

-- Add foreign key constraint for bids table
ALTER TABLE `bids`
ADD CONSTRAINT `fk_bids_auction` FOREIGN KEY (`auction_name`) REFERENCES `auctions` (`auction_name`);

-- ... the rest of your script ...


-- 2023-03-15 17:59:00
