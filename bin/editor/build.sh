#!/usr/bin/env bash

docker compose exec editor yarn build

if test -d ./public/editor; then
  rm -R ./public/editor
fi

if test -d ./depts/editor/dist/editor; then
  mv ./depts/editor/dist/editor ./public/editor
fi

ENV_FILE=".env.dev.local"
NEW_VERSION="$(date +%Y%m%d%H%M%S)"  # oder: NEW_VERSION="$(git rev-parse --short HEAD)"

# Datei anlegen, falls nicht vorhanden
[ -f "$ENV_FILE" ] || touch "$ENV_FILE"

# Zeile ersetzen oder hinzufügen
if grep -qE '^APP_EDITOR_VERSION=' "$ENV_FILE"; then
  # portable inplace (kein sed -i nötig)
  tmpfile="$(mktemp)"
  sed -E "s|^APP_EDITOR_VERSION=.*$|APP_EDITOR_VERSION=${NEW_VERSION}|" "$ENV_FILE" > "$tmpfile" && mv "$tmpfile" "$ENV_FILE"
else
  echo "APP_EDITOR_VERSION=${NEW_VERSION}" >> "$ENV_FILE"
fi
