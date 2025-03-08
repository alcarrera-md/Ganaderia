@echo off
python C:\xamppo\htdocs\ganaderia\exportar_datos.py >> C:\xamppo\htdocs\ganaderia\log.txt 2>&1
python C:\xamppo\htdocs\ganaderia\preprocesar.py >> C:\xamppo\htdocs\ganaderia\log.txt 2>&1
python C:\xamppo\htdocs\ganaderia\entrenar_modelo.py >> C:\xamppo\htdocs\ganaderia\log.txt 2>&1