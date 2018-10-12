--
-- Base de données :  septillion
--

--
-- Structure de la table CATEGORY
--
CREATE TABLE CATEGORY (
  ID_CATEGORY int(16) NOT NULL AUTO_INCREMENT,
  NAME varchar(200),
  DESCRIPTION varchar(200),
  ICON varchar(200),
  CREATED_BY int(16) NOT NULL,
  PRIMARY KEY (ID_CATEGORY)
);

ALTER TABLE CATEGORY AUTO_INCREMENT=1001;

--
-- Structure de la table CLIENT
--
CREATE TABLE CLIENT (
  ID_CLIENT int(16) NOT NULL AUTO_INCREMENT,
  MAIL varchar(200),
  PASSWORD varchar(200),
  FIRST_NAME varchar(200),
  LAST_NAME varchar(200),
  ADDRESS varchar(200),
  PHONE_NUMBER varchar(200),
  PRIMARY KEY (ID_CLIENT)
);

ALTER TABLE CLIENT AUTO_INCREMENT=1001;

--
-- Structure de la table EMPLOYEE
--
CREATE TABLE EMPLOYEE (
  ID_EMPLOYEE int(16) NOT NULL AUTO_INCREMENT,
  MAIL varchar(200),
  PASSWORD varchar(200),
  FIRST_NAME varchar(200),
  LAST_NAME varchar(200),
  ADDRESS varchar(200),
  PHONE_NUMBER varchar(200),
  ROLE varchar(200),
  PRIMARY KEY (ID_EMPLOYEE)
);

ALTER TABLE EMPLOYEE AUTO_INCREMENT=1001;

--
-- Structure de la table FEEDBACK
--
CREATE TABLE FEEDBACK (
  ID_PRODUCT int(16) NOT NULL,
  ID_CLIENT int(16) NOT NULL,
  GRADE int(16),
  COMMENT varchar(5000),
  SUBMIT_DATE datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(ID_PRODUCT, ID_CLIENT)
);

--
-- Structure de la table IS_ORDERED
--
CREATE TABLE IS_ORDERED (
  ID_ORDER int(16) NOT NULL,
  ID_PRODUCT int(16) NOT NULL,
  QUANTITY int(16),
  PRIMARY KEY(ID_ORDER, ID_PRODUCT)
);

--
-- Structure de la table MESSAGE
--
CREATE TABLE MESSAGE (
  ID_MESSAGE int(16) NOT NULL AUTO_INCREMENT,
  OBJECT varchar(200),
  BODY varchar(5000),
  SENT_DATE datetime DEFAULT CURRENT_TIMESTAMP,
  ID_SENDER int(16),
  ID_RECEIVER int(16),
  PRIMARY KEY(ID_MESSAGE)
);

ALTER TABLE MESSAGE AUTO_INCREMENT=1001;

--
-- Structure de la table ORDER
--
CREATE TABLE CLIENT_ORDER (
  ID_ORDER int(16) NOT NULL AUTO_INCREMENT,
  ORDER_DATE datetime DEFAULT CURRENT_TIMESTAMP,
  DESCRIPTION varchar(5000),
  VALIDATED tinyint(1),
  READY tinyint(1),
  COLLECTED tinyint(1),
  ID_CLIENT int(16),
  ID_EMPLOYEE int(16),
  PRIMARY KEY(ID_ORDER)
);

ALTER TABLE CLIENT_ORDER AUTO_INCREMENT=1001;

--
-- Structure de la table PRODUCT
--
CREATE TABLE PRODUCT (
  ID_PRODUCT int(16) NOT NULL AUTO_INCREMENT,
  NAME varchar(200),
  STOCK int(16),
  DESCRITPION varchar(5000),
  PRICE float,
  IMAGE varchar(200),
  CREATED_BY int(16),
  LAST_UPDATED_BY int(16),
  ID_CATEGORY int(16),
  PRIMARY KEY(ID_PRODUCT)
);

ALTER TABLE PRODUCT AUTO_INCREMENT=1001;

--
-- Contraintes pour la table CATEGORY
--
ALTER TABLE CATEGORY
  ADD CONSTRAINT fk_category FOREIGN KEY (CREATED_BY) REFERENCES EMPLOYEE (ID_EMPLOYEE);

--
-- Contraintes pour la table FEEDBACK
--
ALTER TABLE FEEDBACK
  ADD CONSTRAINT fk_feedback_client FOREIGN KEY (ID_CLIENT) REFERENCES CLIENT (ID_CLIENT) ON DELETE CASCADE,
  ADD CONSTRAINT fk_feedback_product FOREIGN KEY (ID_PRODUCT) REFERENCES PRODUCT (ID_PRODUCT) ON DELETE CASCADE;

--
-- Contraintes pour la table IS_ORDERED
--
ALTER TABLE IS_ORDERED
  ADD CONSTRAINT fk_is_ordered_client FOREIGN KEY (ID_ORDER) REFERENCES CLIENT_ORDER (ID_ORDER) ON DELETE CASCADE,
  ADD CONSTRAINT fk_is_ordered_product FOREIGN KEY (ID_PRODUCT) REFERENCES PRODUCT (ID_PRODUCT) ON DELETE CASCADE;

--
-- Contraintes pour la table MESSAGE
--
ALTER TABLE MESSAGE
  ADD CONSTRAINT fk_message_sender FOREIGN KEY (ID_SENDER) REFERENCES EMPLOYEE (ID_EMPLOYEE) ON DELETE CASCADE,
  ADD CONSTRAINT fk_message_receiver FOREIGN KEY (ID_RECEIVER) REFERENCES EMPLOYEE (ID_EMPLOYEE) ON DELETE CASCADE;

--
-- Contraintes pour la table ORDER
--
ALTER TABLE CLIENT_ORDER
  ADD CONSTRAINT fk_order_client FOREIGN KEY (ID_CLIENT) REFERENCES CLIENT (ID_CLIENT) ON DELETE CASCADE,
  ADD CONSTRAINT fk_order_employee FOREIGN KEY (ID_EMPLOYEE) REFERENCES EMPLOYEE (ID_Employee) ON DELETE CASCADE;

--
-- Contraintes pour la table PRODUCT
--
ALTER TABLE PRODUCT
  ADD CONSTRAINT fk_product_created_by FOREIGN KEY (CREATED_BY) REFERENCES EMPLOYEE (ID_EMPLOYEE) ON DELETE CASCADE,
  ADD CONSTRAINT fk_product_last_updated_by FOREIGN KEY (LAST_UPDATED_BY) REFERENCES EMPLOYEE (ID_EMPLOYEE) ON DELETE CASCADE,
  ADD CONSTRAINT fk_product_category FOREIGN KEY (ID_CATEGORY) REFERENCES CATEGORY (ID_CATEGORY) ON DELETE CASCADE;
