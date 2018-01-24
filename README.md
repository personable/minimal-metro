# minimal-metro
A METRO bus tracker serving Portland and Southern Maine. It Uses the Clever Devices [BusTime API](http://bustimeweb.smttracker.com/bustime/apidoc/docs/DeveloperAPIGuide3_0.pdf)
to return bus predictions.

## Why?
I made this for myself -- to dust off my design chops, and because using Transit or Google Travel to see when my bus is coming in the morning felt like drinking from the firehose: I wanted to see results only for the stops I use with a single click.

Just to be clear, though, this tracker is definitely not a replacement for a _real_ transit app!

## Setup
Just needs a web server and gulp to process the Sass. If you are offline (or no buses are running), there are sample json files in the
`json/` directory you can use to return results instead.
