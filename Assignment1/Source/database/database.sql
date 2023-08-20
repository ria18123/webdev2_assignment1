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
('Arushi',	'Datta',	'2023-02-28',	'arushi@gmail.com',	'89e7463b9d2ccb1d165779e99ae601545eb49dcf'),
('dolma',	'sherpa',	'2023-02-21',	'dolma@gmail.com',	'd66327f6d12ef8676c454022c26739ccd546cc79'),
('Rabin',	'Joshi',	'2023-02-06',	'joshi@gmail.com',	'52cfdc16cb8a04cac369e5e4cbee5891d41fa704'),
('Kaji',	'Shrestha',	'2023-02-16',	'kaji@gmail.com',	'96c7dd03cded7224cf9d4c766854ba38b050e080'),
('khan',	'shek',	'2023-02-20',	'khan@gmail.com',	'b9d9cff0706d52fb1a8938117691b34661eed2e8'),
('keshav',	'thapad',	'2023-02-22',	'kull@gmail.com',	'8aa5acc8c6a261fc5ead430e0aeda289d1759f59'),
('Peter',	'Park',	'2022-09-26',	'park@gmail.com',	'01e8906a38c867853c9d8421e76429d765b6aa06'),
('Rajendra',	'Yan',	'2023-02-21',	'raj@gmail.com',	'6c44ae31dde4a327a06fce0c161e2cbcf507dfeb'),
('sassy',	'sups',	'2023-02-10',	'sassy@gmail.com',	'd57ccb6da98c2adabb52b9b0386709620e093da4');


-- Create the categories table
CREATE TABLE `categories` (
  `categoryName` VARCHAR(20) NOT NULL PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the categories table
INSERT INTO `categories` (`categoryName`) VALUES
('Art'), ('Charity'), ('AutoMobiles'), ('Motors'), ('Antiques'), ('Jewelry'),
('Home & Garden'), ('Books'), ('Sports'), ('Technology'),
('Fashion'), ('Health'), ('Toys'), ('Collectibles'), ('Beverages');

-- Create the auctions table with categoryID column
CREATE TABLE `auctions` (
  `auction_name` VARCHAR(90) NOT NULL PRIMARY KEY,
  `auctioneer` VARCHAR(90) DEFAULT NULL,
  `auctionDate` DATE DEFAULT NULL,
  `categoryID` VARCHAR(20) DEFAULT NULL,
  `Description` LONGTEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the auctions table
INSERT INTO `auctions` (`auction_name`, `auctioneer`, `auctionDate`, `categoryID`, `Description`) VALUES
('Art Auction', 'John', '2023-03-15', 'Art', 'Art Auction featuring a diverse collection of modern and contemporary artworks'),
('Charity Auction', 'Emily', '2023-03-10', 'Charity', 'Charity Auction to support local community projects and initiatives'),
('Vintage Car Auction', 'Michael', '2023-03-18', 'AutoMobiles', 'Vintage Car Auction showcasing classic cars from different eras'),
('Antique Furniture Auction', 'Susan', '2023-03-20', 'Antiques', 'Antique Furniture Auction presenting a wide range of exquisite antique pieces'),
('Jewelry Auction', 'Jessica', '2023-03-12', 'Jewelry', 'Jewelry Auction featuring a dazzling collection of rings, necklaces, and more'),
('Wine Auction', 'William', '2023-03-25', 'Beverages', 'Wine Auction offering a curated selection of fine wines and vintages'),
('Rare Book Auction', 'Alex', '2023-03-16', 'Books', 'Rare Book Auction with a focus on unique and collectible literary works'),
('Sports Memorabilia Auction', 'Ryan', '2023-03-14', 'Sports', 'Sports Memorabilia Auction featuring autographed jerseys, equipment, and more'),
('Tech Gadgets Auction', 'Sophia', '2023-03-22', 'Technology', 'Tech Gadgets Auction showcasing the latest electronic devices and gadgets'),
('Fashion Auction', 'Olivia', '2023-03-11', 'Fashion', 'Fashion Auction highlighting designer clothing, accessories, and runway pieces'),
('Coin and Currency Auction', 'Daniel', '2023-03-17', 'Collectibles', 'Coin and Currency Auction featuring rare coins, banknotes, and numismatic items');

-- Update data in the auctions table with correct category IDs
UPDATE `auctions` SET `categoryID` = 'Art' WHERE `auction_name` = 'Art Auction';
UPDATE `auctions` SET `categoryID` = 'Charity' WHERE `auction_name` = 'Charity Auction';
UPDATE `auctions` SET `categoryID` = 'AutoMobiles' WHERE `auction_name` = 'Vintage Car Auction';
UPDATE `auctions` SET `categoryID` = 'Antiques' WHERE `auction_name` = 'Antique Furniture Auction';
UPDATE `auctions` SET `categoryID` = 'Jewelry' WHERE `auction_name` = 'Jewelry Auction';
UPDATE `auctions` SET `categoryID` = 'Beverages' WHERE `auction_name` = 'Wine Auction';
UPDATE `auctions` SET `categoryID` = 'Books' WHERE `auction_name` = 'Rare Book Auction';
UPDATE `auctions` SET `categoryID` = 'Sports' WHERE `auction_name` = 'Sports Memorabilia Auction';
UPDATE `auctions` SET `categoryID` = 'Technology' WHERE `auction_name` = 'Tech Gadgets Auction';
UPDATE `auctions` SET `categoryID` = 'Fashion' WHERE `auction_name` = 'Fashion Auction';
UPDATE `auctions` SET `categoryID` = 'Collectibles' WHERE `auction_name` = 'Collectibles';
-- ... (other auction updates)

-- Add foreign key constraint
ALTER TABLE `auctions`
ADD CONSTRAINT `fk_auctions_category` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryName`);

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
(1, 'khan', 'shek', '2023/03/15', ' Exciting event!', 'Art Auction', 'Y', 'khan@gmail.com'),
(2, 'khan', 'shek', '2023/03/15', ' Can\'t wait!', 'Art Auction', 'Y', 'khan@gmail.com'),
(3, 'Rajendra', 'Yan', '2023/03/16', ' Amazing initiative', 'Charity Auction', 'Y', 'raj@gmail.com'),
(4, 'Rajendra', 'Yan', '2023/03/16', ' Let\'s support!', 'Charity Auction', 'Y', 'raj@gmail.com'),
(5, 'keshav', 'thapad', '2023/03/14', ' Vintage cars are my passion!', 'Vintage Car Auction', 'Y', 'kull@gmail.com'),
(6, 'keshav', 'thapad', '2023/03/14', ' Exciting collection', 'Vintage Car Auction', 'Y', 'kull@gmail.com'),
(7, 'Kaji', 'Shrestha', '2023/03/18', ' Love antique furniture!', 'Antique Furniture Auction', 'Y', 'kaji@gmail.com'),
(8, 'Kaji', 'Shrestha', '2023/03/18', ' Can\'t wait to see them', 'Antique Furniture Auction', 'Y', 'kaji@gmail.com'),
(9, 'Riya', 'Shrestha', '2023/11/18', ' Love vintage wines', 'Wine Auction ', 'Y', 'kaji@gmail.com');

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
