docker rm -f teste-bref
docker build -f Dockerfile.local -t jonathanbraz/bref .
docker run -d -p 8090:8090 --env-file ./.env --name teste-bref jonathanbraz/bref

#docker exec -it teste-bref sh
