CREATE TABLE product_type (
 id INT NOT NULL,
 name TEXT
);

ALTER TABLE product_type ADD CONSTRAINT PK_product_type PRIMARY KEY (id);


CREATE TABLE product_type_tax (
 id INT NOT NULL,
 created_at TIMESTAMP WITH TIME ZONE,
 tax_percentage NUMERIC,
 product_type_id INT NOT NULL
);

ALTER TABLE product_type_tax ADD CONSTRAINT PK_product_type_tax PRIMARY KEY (id);


CREATE TABLE sale (
 id INT NOT NULL,
 created_at TIMESTAMP WITH TIME ZONE
);

ALTER TABLE sale ADD CONSTRAINT PK_sale PRIMARY KEY (id);


CREATE TABLE product (
 id INT NOT NULL,
 name TEXT,
 product_type_id INT NOT NULL
);

ALTER TABLE product ADD CONSTRAINT PK_product PRIMARY KEY (id);


CREATE TABLE product_price (
 id INT NOT NULL,
 product_id INT NOT NULL,
 created_at TIMESTAMP WITH TIME ZONE,
 price NUMERIC
);

ALTER TABLE product_price ADD CONSTRAINT PK_product_price PRIMARY KEY (id);


CREATE TABLE sale_product (
 id INT NOT NULL,
 product_type_tax_id INT NOT NULL,
 sale_id INT NOT NULL,
 product_price_id INT NOT NULL,
 amount NUMERIC
);

ALTER TABLE sale_product ADD CONSTRAINT PK_sale_product PRIMARY KEY (id);


ALTER TABLE product_type_tax ADD CONSTRAINT FK_product_type_tax_0 FOREIGN KEY (product_type_id) REFERENCES product_type (id);


ALTER TABLE product ADD CONSTRAINT FK_product_0 FOREIGN KEY (product_type_id) REFERENCES product_type (id);


ALTER TABLE product_price ADD CONSTRAINT FK_product_price_0 FOREIGN KEY (product_id) REFERENCES product (id);


ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_0 FOREIGN KEY (product_type_tax_id) REFERENCES product_type_tax (id);
ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_1 FOREIGN KEY (sale_id) REFERENCES sale (id);
ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_2 FOREIGN KEY (product_price_id) REFERENCES product_price (id);
