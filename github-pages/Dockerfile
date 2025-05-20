FROM ruby

RUN mkdir /site
WORKDIR /site
#COPY ./jekotia.github.io/Gemfile .
ADD https://raw.githubusercontent.com/Jekotia/jekotia.github.io/refs/heads/master/Gemfile .
RUN bundle install
RUN bundle update github-pages

EXPOSE 4000/tcp
#ENTRYPOINT ["bundle", "exec", "jekyll", "serve"]
CMD jekyll serve /site --watch --force_polling --host 0.0.0.0 --port 4000
