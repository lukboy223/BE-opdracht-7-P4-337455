<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
           -- Database creation script for Vehicle Instructor Management System

-- Drop tables if they exist to avoid conflicts
DROP TABLE IF EXISTS VoertuigInstructeur;
DROP TABLE IF EXISTS Voertuig;
DROP TABLE IF EXISTS TypeVoertuig;
DROP TABLE IF EXISTS Instructeur;

-- Create TypeVoertuig table
CREATE TABLE TypeVoertuig (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    TypeVoertuig VARCHAR(50) NOT NULL,
    Rijbewijscategorie VARCHAR(5) NOT NULL
);

-- Create Instructeur table
CREATE TABLE Instructeur (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Mobiel VARCHAR(12) NOT NULL,
    DatumInDienst DATE NOT NULL,
    AantalSterren VARCHAR(5) NULL
);

-- Create Voertuig table
CREATE TABLE Voertuig (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Kenteken VARCHAR(12) NOT NULL,
    Type VARCHAR(50) NOT NULL,
    Bouwjaar DATE NOT NULL,
    Brandstof VARCHAR(20) NOT NULL,
    TypeVoertuigId INT NOT NULL,
    FOREIGN KEY (TypeVoertuigId) REFERENCES TypeVoertuig(Id)
);

-- Create VoertuigInstructeur table (junction table)
CREATE TABLE VoertuigInstructeur (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    VoertuigId INT NOT NULL,
    InstructeurId INT NOT NULL,
    DatumToekenning DATE NOT NULL,
    FOREIGN KEY (VoertuigId) REFERENCES Voertuig(Id),
    FOREIGN KEY (InstructeurId) REFERENCES Instructeur(Id)
);

-- Insert data into TypeVoertuig table
INSERT INTO TypeVoertuig (Id, TypeVoertuig, Rijbewijscategorie) VALUES
(1, 'Personenauto', 'B'),
(2, 'Vrachtwagen', 'C'),
(3, 'Bus', 'D'),
(4, 'Bromfiets', 'AM');

-- Insert data into Instructeur table
INSERT INTO Instructeur (Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren) VALUES
(1, 'Li', NULL, 'Zhan', '06-28493827', '2015-04-17', '***'),
(2, 'Leroy', NULL, 'Boerhaven', '06-39398734', '2018-06-25', '*'),
(3, 'Yoeri', 'Van', 'Veen', '06-24383291', '2010-05-12', '***'),
(4, 'Bert', 'Van', 'Sali', '06-48293823', '2023-01-10', '****'),
(5, 'Mohammed', 'El', 'Yassidi', '06-34291234', '2010-06-14', '*****');

-- Insert data into Voertuig table
INSERT INTO Voertuig (Id, Kenteken, Type, Bouwjaar, Brandstof, TypeVoertuigId) VALUES
(1, 'AU-67-IO', 'Golf', '2017-06-12', 'Diesel', 1),
(2, 'TR-24-OP', 'DAF', '2019-05-23', 'Diesel', 2),
(3, 'TH-78-KL', 'Mercedes', '2023-01-01', 'Benzine', 1),
(4, '90-KL-TR', 'Fiat 500', '2021-09-12', 'Benzine', 1),
(5, '34-TK-LP', 'Scania', '2015-03-13', 'Diesel', 2),
(6, 'YY-OP-78', 'BMW M5', '2022-05-13', 'Diesel', 1),
(7, 'UU-HH-JK', 'M.A.N', '2017-12-03', 'Diesel', 2),
(8, 'ST-FZ-28', 'Citroën', '2018-01-20', 'Elektrisch', 1),
(9, '123-FR-T', 'Piaggio ZIP', '2021-02-01', 'Benzine', 4),
(10, 'DRS-52-P', 'Vespa', '2022-03-21', 'Benzine', 4),
(11, 'STP-12-U', 'Kymco', '2022-07-02', 'Benzine', 4),
(12, '45-SD-23', 'Renault', '2023-01-01', 'Diesel', 3);

-- Insert data into VoertuigInstructeur table
INSERT INTO VoertuigInstructeur (Id, VoertuigId, InstructeurId, DatumToekenning) VALUES
(1, 1, 5, '2017-06-18'),
(2, 3, 1, '2021-09-26'),
(3, 9, 1, '2021-09-27'),
(4, 4, 4, '2022-08-01'),
(5, 5, 1, '2019-08-30'),
(6, 10, 5, '2020-02-02');

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
