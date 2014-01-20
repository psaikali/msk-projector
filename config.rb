# Require any additional compass plugins here.
require "compass-recipes"

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "library/css"
sass_dir = "library/scss"
images_dir = "library/images"
javascripts_dir = "library/js"
fonts_dir = "library/css"

output_style = :expanded

# To enable relative paths to library via compass helper functions. Uncomment:
# relative_library = true

line_comments = false
color_output = false

require 'fileutils'
on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Moving style.css: #{file}"
    FileUtils.mv(file, File.dirname(file) + "/../../" + File.basename(file))
  end
end

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass library/css scss && rm -rf sass && mv scss sass
