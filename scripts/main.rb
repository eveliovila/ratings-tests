#!/usr/bin/ruby

require 'csv'
require 'mysql'
require 'feed.rb'
require 'time'
require 'net/smtp'

while true
    #Retrive user's list

    now = Time.now.strftime("%Y-%m-%d")
    my = Mysql.real_connect(m_host,m_user,m_pass,m_base,m_port)
    my.query("select user_id from Users").each do |user|
        update("/kunden/homepages/31/d496602924/htdocs/ratings/#{user}-#{now}.csv", user)
    end

    my.close if my

    sleep(21600)
end


