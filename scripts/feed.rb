#!/usr/bin/ruby

require 'csv'
require 'mysql'
require 'date'


def update(file_path,uid)

m_host  = ''
m_port  = 
m_user  =''
m_pass = ''
m_base = ''



    my = Mysql.real_connect(m_host,m_user,m_pass,m_base,m_port)
    rates=CSV.readlines(file_path)
    rates.shift


# Ugly stuff; no idea where do these perls come from..
# they are nor mysql datatypes nor rubys, nor anything
# Date::MONTHNAMES.index("Jun") => nil ....lol

months ={"Apr"=>"4", "Sep"=>"9", "Aug"=>"8", "Jul"=>"7", "Jun"=>"6", "Jan"=>"1", "May"=>"5",
        "Mar"=>"3", "Nov"=>"11", "Dec"=>"12", "Oct"=>"10", "Feb"=>"2"}

    rates.each do |row|

        # lol we do not support ' 
        row.map!{ |element| element.gsub(/'/, '') }

        film_id     = row[1]
        created     = row[2]
        modified    = row[3]
        rate        = row[8]
        title       = row[5]
        type        = row[6]
        directors   = row[7]
        imdb_rating = row[9]
        runtime     = row[10]
        genre       = row[12]
        year        = row[11]
        total_votes = row[13]
        url         = row[15]
        release_date= row[14]


    d=created.split
    created=d[4]+'-'+months[d[1]]+'-'+d[2]

    if modified.empty?
           modified = created
           end

        # imdb rate

        if y=my.query("select IMDb_Rating from Films where const='#{film_id}'").fetch_row
            unless y.eql? imdb_rating
                my.query("update Films set IMDb_Rating='#{imdb_rating}' where const='#{film_id}'")
            end
        else
            my.query("INSERT INTO Films set const='#{film_id}',Title='#{title}',
                Type='#{type}',Directors='#{directors}',IMDb_Rating='#{imdb_rating}',Year='#{year}',
                Runtime='#{runtime}',Genre='#{genre}',Total_votes='#{total_votes}', url='#{url}',
                Release_date='#{release_date}'")
         end

        # user rate
        if x= my.query("select Rate from Rates where const='#{film_id}' and User_id='#{uid}'").fetch_row
            unless x.eql? rate
                my.query("update Rates set Rate='#{rate}',Modified='#{modified}' where User_id='#{uid}' and const='#{film_id}'")
            end
        else
            my.query("INSERT INTO Rates SET User_id='#{uid}',const='#{film_id}',Rate='#{rate}',
                Created='#{created}',Modified='#{modified}'")
        end

        end

    my.close if my

end

