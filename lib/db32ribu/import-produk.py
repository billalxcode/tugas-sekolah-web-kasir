import time
from rich.progress import Progress, BarColumn, TextColumn
from rich.table import Column
import mysql.connector
import pandas as pd

text_column = TextColumn("{task.description}", table_column=Column(ratio=1))
bar_column = BarColumn(bar_width=None, table_column=Column(ratio=2))
progress = Progress(text_column, bar_column, expand=True)
database = mysql.connector.connect(
    host="localhost",
    user="billal",
    passwd="12345",
    database="sikasir"
)
data_header = [
    "KODE_BARANG",
    "KODE_BARCODE",
    "KODE_BARCODE_2",
    "KODE_BARCODE_3",
    "NAMA",
    "KATEGORI",
    "SUB_KATEGORI",
    "SUPPLIER",
    "TANGGAL_BELI",
    "ISI",
    "ISI_SATUAN_3",
    "SATUAN_1",
    "SATUAN_2",
    "SATUAN_3",
    "TOKO",
    "GUDANG",
    "HPP",
    "HARGA_TOKO_1",
    "HARGA_TOKO_2",
    "HARGA_TOKO_3",
    "HARGA_PARTAI_1",
    "HARGA_PARTAI_2",
    "HARGA_PARTAI_3",
    "HARGA_CABANG_1",
    "HARGA_CABANG_2",
    "HARGA_CABANG_3",
    "LOKASI",
    "UKURAN",
    "WARNA",
    "NAMA_2",
    "NAMA_3",
    "STOK_MIN",
    "STOK_MAX"
]
xl = pd.ExcelFile("./data barang 30.000 unit.xls")
df = xl.parse("Sheet1", header=None, names=data_header)
with progress:
    progress.print("[bold blue]Starting work!")
    for idx in progress.track(range(1, df.size), description="Importing to database"):
        try:
            cursor = database.cursor()
            cursor.execute("INSERT INTO produk (id, barcode, nama, harga, stok) VALUES (%s, %s, %s, %s, %s)", (
                idx,
                df["KODE_BARCODE"].iloc[idx],
                df["NAMA"].iloc[idx],
                df["HARGA_TOKO_1"].iloc[idx],
                100
            ))
            database.commit()
            progress.print("Success " + df["NAMA"].iloc[idx])
        except mysql.connector.errors.DatabaseError as e:
            progress.print("[bold red]Failed " + e.msg + " -> " + df["NAMA"].iloc[idx])