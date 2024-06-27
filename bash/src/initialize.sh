APP_ROOT="$(dirname "$(dirname "$(readlink -fm "$0")")")"

SSL_EMAIL="pdf-api@swisstph.ch"

error_msg(){ printf %s"\n$(red Error!)\n${1}\nExiting (1)\n\n"; exit 1; }

if [[ "${APP_ENV}" == "dev" ]]; then           
    printf "Detected 'development' environment."
elif [[ "${APP_ENV}" == "test" ]]; then
    printf "Detected 'testing' environment."
elif [[ "${APP_ENV}" == "prod" ]]; then
    printf "Detected 'production' environment."
else
    error_msg "No valid environment detected: '${APP_ENV}'"
fi
echo


# check if command cli cert create
# if ! [[ -z "${SSL_DOMAIN}" ]]; then

#     validate="^([a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$"

#     if ! [[ "${SSL_DOMAIN}" =~ $validate ]]; then
#         error_msg "No valid domain name detected: '${SSL_DOMAIN}'"
#     fi

# fi