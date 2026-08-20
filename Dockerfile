# Petit conteneur de dev : PHP + serveur intégré.
# Suffisant pour tester index.php et admin.php en local.
# (En prod c'est OVH mutualisé sous Apache/mod_php — voir CLAUDE.md.)
FROM php:8.3-cli

WORKDIR /var/www/html

# Copie du code (pratique pour `docker run` sans volume).
# En dev, docker-compose monte un volume qui prend le dessus → édition à chaud.
COPY . .

EXPOSE 8000

# Serveur intégré PHP. Tourne en root → peut créer config.php et écrire data/.
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
