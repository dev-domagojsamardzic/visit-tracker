<?php

require 'Database.php';

class Visits {

    /**
     * @var Database
     */
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * Get visits by
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getVisits(?string $startDate = null, ?string $endDate = null) : array
    {
        $sql = "SELECT page, COUNT(*) AS unique_visits FROM visits";

        $params = [];

        if ($startDate && $endDate) {
            $sql .= " WHERE date BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }

        $sql .= " GROUP BY page ORDER BY unique_visits DESC";

        $statement = $this->database->execute($sql, $params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}