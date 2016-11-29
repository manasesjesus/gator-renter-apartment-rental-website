ALTER TABLE users
ADD COLUMN first_name VARCHAR(255) NULL DEFAULT NULL AFTER uid,
ADD COLUMN last_name VARCHAR(255) NULL DEFAULT NULL AFTER first_name,
ADD COLUMN user_roles_id INT(11) NULL DEFAULT NULL AFTER created,
ADD COLUMN is_active INT(2) NULL DEFAULT 1 AFTER user_roles_id,
ADD INDEX fk_users_user_roles_idx (user_roles_id ASC);

CREATE TABLE IF NOT EXISTS user_roles (
  id INT(11) NOT NULL AUTO_INCREMENT,
  role_name VARCHAR(100) NOT NULL,
  role_description VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE users
ADD CONSTRAINT fk_users_user_roles
  FOREIGN KEY (user_roles_id)
  REFERENCES user_roles (id)
  ON DELETE SET NULL
  ON UPDATE CASCADE;


# populating roles table
INSERT INTO user_roles (id, role_name, role_description) VALUES ('1', 'Administrator', 'Admin');
INSERT INTO user_roles (id, role_name, role_description) VALUES ('2', 'Landlord', 'owner of house');
INSERT INTO user_roles (id, role_name, role_description) VALUES ('3', 'Renter', 'Tenant, want to live');
