<?php

abstract class Model
{
    // Each subclass must define these
    protected static string $table    = '';
    protected static string $primary  = 'id';

    // ─── QUERY BUILDER STATE ──────────────────────────────────────────────────

    private static array $wheres  = [];
    private static array $orders  = [];
    private static ?int  $limit_  = null;
    private static ?int  $offset_ = null;

    // ─── STATIC QUERY BUILDER METHODS ────────────────────────────────────────

    public static function where(string $column, string $operator, mixed $value): static
    {
        static::$wheres[] = compact('column', 'operator', 'value');
        return new static();
    }

    public static function orderBy(string $column, string $direction = 'ASC'): static
    {
        static::$orders[] = "{$column} " . strtoupper($direction);
        return new static();
    }

    public static function limit(int $n): static
    {
        static::$limit_ = $n;
        return new static();
    }

    public static function offset(int $n): static
    {
        static::$offset_ = $n;
        return new static();
    }

    // ─── FINDERS ─────────────────────────────────────────────────────────────

    /** Return all rows */
    public static function all(): array
    {
        return static::buildSelect()->fetchAll();
    }

    /** Find by primary key */
    public static function find(int|string $id): ?array
    {
        $db  = Database::getInstance();
        $sql = sprintf('SELECT * FROM `%s` WHERE `%s` = ? LIMIT 1', static::$table, static::$primary);
        $st  = $db->prepare($sql);
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ?: null;
    }

    /** Return the first result */
    public static function first(): ?array
    {
        static::$limit_ = 1;
        $rows = static::buildSelect()->fetchAll();
        return $rows[0] ?? null;
    }

    // ─── CRUD ────────────────────────────────────────────────────────────────

    /**
     * INSERT a new row.
     * Returns the new primary key.
     */
    public static function create(array $data): int|string
    {
        $db      = Database::getInstance();
        $columns = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $cols    = implode('`, `', $columns);
        $sql     = sprintf('INSERT INTO `%s` (`%s`) VALUES (%s)', static::$table, $cols, $placeholders);
        $st      = $db->prepare($sql);
        $st->execute(array_values($data));
        return $db->lastInsertId();
    }

    /**
     * UPDATE a row by primary key.
     */
    public static function update(int|string $id, array $data): bool
    {
        $db  = Database::getInstance();
        $set = implode(', ', array_map(fn($col) => "`{$col}` = ?", array_keys($data)));
        $sql = sprintf('UPDATE `%s` SET %s WHERE `%s` = ?', static::$table, $set, static::$primary);
        $st  = $db->prepare($sql);
        return $st->execute([...array_values($data), $id]);
    }

    /**
     * DELETE a row by primary key.
     */
    public static function delete(int|string $id): bool
    {
        $db  = Database::getInstance();
        $sql = sprintf('DELETE FROM `%s` WHERE `%s` = ?', static::$table, static::$primary);
        $st  = $db->prepare($sql);
        return $st->execute([$id]);
    }

    /**
     * COUNT rows (with optional WHERE applied from builder).
     */
    public static function count(): int
    {
        [$sql, $bindings] = static::buildWhereClause();
        $query = sprintf('SELECT COUNT(*) FROM `%s`', static::$table) . $sql;
        $db    = Database::getInstance();
        $st    = $db->prepare($query);
        $st->execute($bindings);
        static::resetBuilder();
        return (int) $st->fetchColumn();
    }

    // ─── RAW QUERY ───────────────────────────────────────────────────────────

    public static function raw(string $sql, array $bindings = []): array
    {
        $db = Database::getInstance();
        $st = $db->prepare($sql);
        $st->execute($bindings);
        return $st->fetchAll();
    }

    // ─── INTERNAL HELPERS ────────────────────────────────────────────────────

    private static function buildSelect(): \PDOStatement
    {
        [$whereClause, $bindings] = static::buildWhereClause();

        $sql = sprintf('SELECT * FROM `%s`', static::$table) . $whereClause;

        if (!empty(static::$orders)) {
            $sql .= ' ORDER BY ' . implode(', ', static::$orders);
        }
        if (static::$limit_ !== null) {
            $sql .= ' LIMIT ' . static::$limit_;
        }
        if (static::$offset_ !== null) {
            $sql .= ' OFFSET ' . static::$offset_;
        }

        $db = Database::getInstance();
        $st = $db->prepare($sql);
        $st->execute($bindings);
        static::resetBuilder();
        return $st;
    }

    private static function buildWhereClause(): array
    {
        if (empty(static::$wheres)) {
            return ['', []];
        }

        $conditions = [];
        $bindings   = [];

        foreach (static::$wheres as $w) {
            $conditions[] = sprintf('`%s` %s ?', $w['column'], $w['operator']);
            $bindings[]   = $w['value'];
        }

        return [' WHERE ' . implode(' AND ', $conditions), $bindings];
    }

    private static function resetBuilder(): void
    {
        static::$wheres  = [];
        static::$orders  = [];
        static::$limit_  = null;
        static::$offset_ = null;
    }
}
