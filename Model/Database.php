<?php

namespace Model;

class Database
{
    /** @var \mysqli */
    private $connection;

    private function getConnection(): \mysqli
    {
        if ($this->connection === null) {
            $this->connection = mysqli_connect(
                "127.0.0.1",
                "root",
                "-§#F8E,%4JKPJAtUMtBFMTKMv.Q&m",
                "bundesliga"
            );
        }
        return $this->connection;
    }

    /**
     * @param string $sqlCommand
     * @return bool|\mysqli_result
     * @throws \Exception
     */
    private function query(string $sqlCommand)
    {
//        echo $sqlCommand . PHP_EOL;

        $result = mysqli_query($this->getConnection(), $sqlCommand);

        if ($result === false) {
            throw new \Exception(mysqli_error($this->getConnection()));
        }

        return $result;
    }

    public function insert(string $table, array $values): void
    {
        $cmd = 'INSERT INTO ' . $table . ' ' .
            '(' . implode(',', array_keys($values)) . ') VALUES ' .
            '(' . $this->quoteList($values) . ')';

        $this->query($cmd);
    }

    private function quoteList(array $values): string
    {
        $result = [];
        foreach ($values as $value) {
//            if (is_null($value)) {
//                $result[] = null;
//            } else {
//                $result[] = $this->quote($value);
//            }
            $result[] = is_null($value) ? 'NULL' : $this->quote($value);
        }
        return implode(', ', $result);
    }

    private function quote(string $value): string
    {
        // escapen = ' => \'
        // quoten = anführungsstrichle aussen rum
        return "'" . $this->getConnection()->escape_string($value) . "'";
    }

    public function truncate(string $table): void
    {
        $this->query('TRUNCATE ' . $table);
    }

    public function getRows(string $query): array
    {
//        $result = $this->query($query);
//        while ($row = mysqli_fetch_assoc($result)) {
//            var_dump($row);
//        }
        return mysqli_fetch_all($result = $this->query($query), MYSQLI_ASSOC);
    }
}