FROM node:18.15-alpine3.16

WORKDIR /var/www/Front

COPY ./Front/package*.json ./

RUN npm install

# add app
COPY ./Front ./

EXPOSE 4200

RUN npm install -g @angular/cli

# start app
CMD npm start
