CREATE TABLE sale (
 id SERIAL NOT NULL,
 created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE sale ADD CONSTRAINT PK_sale PRIMARY KEY (id);


CREATE TABLE type_product (
 id SERIAL NOT NULL,
 name TEXT NOT NULL
);

ALTER TABLE type_product ADD CONSTRAINT PK_type_product PRIMARY KEY (id);


CREATE TABLE type_product_tax (
 id SERIAL NOT NULL,
 created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 tax_percentage NUMERIC NOT NULL,
 type_product_id INT NOT NULL
);

ALTER TABLE type_product_tax ADD CONSTRAINT PK_type_product_tax PRIMARY KEY (id);


CREATE TABLE product (
 id SERIAL NOT NULL,
 name TEXT NOT NULL,
 type_product_id INT NOT NULL
);

ALTER TABLE product ADD CONSTRAINT PK_product PRIMARY KEY (id);


CREATE TABLE product_price (
 id SERIAL NOT NULL,
 product_id INT NOT NULL,
 created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 value NUMERIC NOT NULL
);

ALTER TABLE product_price ADD CONSTRAINT PK_product_price PRIMARY KEY (id);


CREATE TABLE sale_product (
 id SERIAL NOT NULL,
 type_product_tax_id INT NOT NULL,
 sale_id INT NOT NULL,
 product_price_id INT NOT NULL,
 amount NUMERIC NOT NULL
);

ALTER TABLE sale_product ADD CONSTRAINT PK_sale_product PRIMARY KEY (id);

ALTER TABLE type_product_tax ADD CONSTRAINT FK_type_product_tax_0 FOREIGN KEY (type_product_id) REFERENCES type_product (id);

ALTER TABLE product ADD CONSTRAINT FK_product_0 FOREIGN KEY (type_product_id) REFERENCES type_product (id);

ALTER TABLE product_price ADD CONSTRAINT FK_product_price_0 FOREIGN KEY (product_id) REFERENCES product (id);

ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_0 FOREIGN KEY (type_product_tax_id) REFERENCES type_product_tax (id);
ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_1 FOREIGN KEY (sale_id) REFERENCES sale (id);
ALTER TABLE sale_product ADD CONSTRAINT FK_sale_product_2 FOREIGN KEY (product_price_id) REFERENCES product_price (id);
