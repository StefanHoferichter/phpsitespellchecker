#!/bin/bash
cd /var/www/html/rezeptexperte/languagetool/LanguageTool-6.6/
java -cp "languagetool-server.jar:." org.languagetool.server.HTTPServer --config server.properties --port 8081 --allow-origin