#!/usr/bin/ruby

require 'mysql'
require 'time'


my = Mysql.real_connect(m_host,m_user,m_pass,m_base,m_port)

    #Retrive user's list


    now = Time.now.strftime("%Y-%m-%d")

    my.query("select user_id from Users").each do |user|
        system(`/usr/bin/wget 'http://www.imdb.com/list/export?list_id=ratings&author_id=ur#{user}' -O /kunden/homepages/31/d496602924/htdocs/ratings/#{user}-#{now}.csv`)
    end

my.close if my

