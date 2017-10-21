CREATE DATABASE IF NOT EXISTS cradle;
CREATE TABLE IF NOT EXISTS emergency_consults (
  id int AUTO_INCREMENT NOT NULL,
  patient_id int UNSIGNED NOT NULL,
  date_in date NOT NULL,
  time_in time NOT NULL,
  disposition varchar(100),
  dispo_date date NOT NULL,
  dispo_time time NOT NULL,
  PRIMARY KEY (id),
  UNIQUE(patient_id, date_in, time_in)
);

CREATE TABLE IF NOT EXISTS admissions (
  id int AUTO_INCREMENT NOT NULL,
  patient_id int UNSIGNED NOT NULL,
  date_in date NOT NULL,
  time_in time NOT NULL,
  source varchar(100),
  initial_service varchar(100),
  current_service varchar(100),
  initial_location varchar(100),
  current_location varchar(100),
  disposition varchar(100),
  dispo_date date NOT NULL,
  dispo_time time,
  PRIMARY KEY (id),
  UNIQUE(patient_id, date_in, time_in)
);

CREATE TABLE IF NOt EXISTS transfers (
  id int AUTO_INCREMENT NOT NULL,
  admission_id int UNSIGNED NOT NULL,
  date_transfer date NOT NULL,
  time_transfer time NOT NULL,
  source_location varchar(100),
  target_location varchar(100),
  source_service varchar(100),
  target_service varchar(100),
  PRIMARY KEY (id),
  UNIQUE(admission_id, date_transfer, time_transfer)
);
