FROM node:lts-alpine as build-stage
WORKDIR /admin
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# production stage
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /admin/dist /usr/share/nginx/html

COPY conf.d/site.conf /etc/nginx/conf.d/

RUN rm /etc/nginx/conf.d/default.conf

#EXPOSE 80
CMD sed -i -e 's/$PORT/'"$PORT"'/g' /etc/nginx/conf.d/site.conf && nginx -g 'daemon off;'

#CMD ["nginx", "-g", "daemon off;"]
