# Add new field to users table

ALTER TABLE users ADD COLUMN appendpassword BOOLEAN;
ALTER TABLE releases ADD COLUMN password VARCHAR(255);
