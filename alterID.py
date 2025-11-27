import sqlite3

DB_PATH = 'database/db.sqlite'  # Cambia con il percorso del tuo database

def make_id_primary(table):
    conn = sqlite3.connect(DB_PATH)
    c = conn.cursor()

    # Ottieni la struttura della tabella
    c.execute(f"PRAGMA table_info({table})")
    columns = c.fetchall()
    col_names = [col[1] for col in columns]
    col_defs = []
    for col in columns:
        if col[1] == 'payment_id':
            col_defs.append('payment_id INTEGER PRIMARY KEY')
        else:
            col_defs.append(f"{col[1]} {col[2]}")
    col_defs_str = ', '.join(col_defs)

    # Crea la nuova tabella
    c.execute(f"CREATE TABLE {table}_new ({col_defs_str})")

    # Copia i dati
    cols_str = ', '.join(col_names)
    c.execute(f"INSERT INTO {table}_new ({cols_str}) SELECT {cols_str} FROM {table}")

    # Elimina la vecchia tabella e rinomina
    c.execute(f"DROP TABLE {table}")
    c.execute(f"ALTER TABLE {table}_new RENAME TO {table}")

    conn.commit()
    conn.close()
    print(f"Tabella '{table}' aggiornata!")

if __name__ == '__main__':
    # Elenca le tabelle che vuoi modificare
    tables = ['payments']  # aggiungi altre se necessario
    for t in tables:
        make_id_primary(t)