CREATE DATABASE IF NOT EXISTS ResultManagement;
USE ResultManagement;

CREATE TABLE Results (
  ResultID   INT AUTO_INCREMENT PRIMARY KEY,
  StudentID  VARCHAR(20) NOT NULL,
  Name       VARCHAR(100) NOT NULL,
  Semester   TINYINT      NOT NULL,
  Subject1   INT          NOT NULL,
  Subject2   INT          NOT NULL,
  Subject3   INT          NOT NULL,
  Subject4   INT          NOT NULL,
  TotalMarks INT          NOT NULL,
  Percentage DECIMAL(5,2) NOT NULL,
  Class      VARCHAR(20)  NOT NULL,
  INDEX(idx_student) (StudentID),
  INDEX(idx_class_sem) (Class, Semester)
);
