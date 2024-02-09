CREATE TABLE `clothing` (
  `product_id` INT NOT NULL,
  `size` VARCHAR(20),
  `color` VARCHAR(20),
  `type` VARCHAR(20),
  `material_fee` INT,
  PRIMARY KEY (`product_id`),
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
);

CREATE TABLE `electronics` (
  `product_id` INT NOT NULL,
  `brand` VARCHAR(50),
  `warranty_fee` INT,
  PRIMARY KEY (`product_id`),
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
);
