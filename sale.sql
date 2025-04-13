-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2025 at 04:08 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sale`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_sales_transaction` (IN `p_sales_reference` VARCHAR(100), IN `p_sales_date` DATETIME, IN `p_product_code` VARCHAR(50), IN `p_quantity` INT, IN `p_price` INT)   BEGIN
  DECLARE p_subtotal INT;

  SET p_subtotal = p_quantity * p_price;

  START TRANSACTION;

  INSERT INTO sales (sales_reference, sales_date, product_code, quantity, price, subtotal)
  VALUES (p_sales_reference, p_sales_date, p_product_code, p_quantity, p_price, p_subtotal);

  UPDATE product
  SET stock = stock - p_quantity
  WHERE product_code = p_product_code;

  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_top_product` ()   BEGIN
    SELECT 
        p.product_name,
        SUM(s.quantity) AS total_sales
    FROM 
        sales s
    JOIN 
        product p ON s.product_code = p.product_code
    GROUP BY 
        p.product_name
    ORDER BY 
        total_sales DESC
    LIMIT 5;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `product_code`, `product_name`, `price`, `stock`) VALUES
(1, 'S200', 'Sepatu', 100000, 10),
(2, 'S100', 'Sandal', 20000, 15),
(4, 'T100', 'Sling Bag', 35000, 15),
(5, 'J100', 'Jaket', 100000, 26),
(7, 'T200', 'Hand Bag', 750000, 18),
(9, 'S500', 'Kaos Kaki', 10000, 97);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id_sales` int NOT NULL,
  `sales_reference` varchar(100) NOT NULL,
  `sales_date` datetime NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id_sales`, `sales_reference`, `sales_date`, `product_code`, `quantity`, `price`, `subtotal`) VALUES
(1, 'REF67fbd39917f2e', '2025-04-13 22:09:13', 'S100', 2, '20000.00', '40000.00'),
(2, 'REF67fbd3cc1de56', '2025-04-13 22:10:04', 'S100', 2, '20000.00', '40000.00'),
(3, 'REF67fbd6b390cf5', '2025-04-13 22:22:27', 'S100', 1, '20000.00', '20000.00'),
(4, 'REF67fbd71090f39', '2025-04-13 22:24:00', 'T100', 2, '35000.00', '70000.00'),
(5, 'REF67fbdaa5ce08e', '2025-04-13 22:39:17', 'T100', 3, '35000.00', '105000.00'),
(6, 'REF67fbdac17d7ea', '2025-04-13 22:39:45', 'J100', 4, '100000.00', '400000.00'),
(7, 'REF67fbdad10532f', '2025-04-13 22:40:01', 'T200', 2, '750000.00', '1500000.00'),
(9, 'REF67fbdbcb5df87', '2025-04-13 22:44:11', 'S500', 3, '10000.00', '30000.00'),
(10, 'REF67fbdbdc99127', '2025-04-13 22:44:28', 'T200', 10, '750000.00', '7500000.00'),
(11, 'REF67fbdc96ea646', '2025-04-13 22:47:34', 'S200', 10, '100000.00', '1000000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id_sales`),
  ADD UNIQUE KEY `sales_reference` (`sales_reference`),
  ADD KEY `product_code` (`product_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id_sales` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_code`) REFERENCES `product` (`product_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
