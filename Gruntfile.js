'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    notify: {
      sass: {
        options: {
          title: 'Task Complete',  // optional
          message: 'SASS finished running', //required
        }
      },
      js: {
        options: {
          title: 'Task Complete',  // optional
          message: 'jsHint and Uglify finished running', //required
        }
      },
    },
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/*.js',
        '!assets/js/admin.main.js'
      ]
    },
    sass: {
      dist: {
        options: {
          style: 'expanded',
          lineNumbers: true,
          compass: true,
          // Source maps are available, but require Sass 3.3.0 to be installed
          // https://github.com/gruntjs/grunt-contrib-sass#sourcemap
          sourcemap: false
        },
        files: {
          'assets/css/admin.main.css': [
            'assets/sass/admin.scss'
          ]
        }
      }
    },
    uglify: {
      dist: {
        files: {
          'assets/js/admin.main.js': [
            'assets/js/admin.js'
          ]
        },
        options: {
          // JS source map: to enable, uncomment the lines below and update sourceMappingURL based on your install
          // sourceMap: 'assets/js/scripts.min.js.map',
          // sourceMappingURL: '/app/themes/roots/assets/js/scripts.min.js.map'
        }
      }
    },
    watch: {
      sass: {
        files: [
          'assets/sass/*.scss',
          'assets/js/*.js',
        ],
        tasks: ['sass', 'notify:sass'],
        options: {
          interrupt: true,
        }
      },
      js: {
        files: [
          '<%= jshint.all %>'
        ],
        tasks: ['jshint', 'uglify', 'notify:js']
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: true
        },
        files: [
          '*.php',
          'views/*.php',
          'views/admin/*.php',
          'assets/css/admin.main.css' // reload when this file changes (dest)
        ]
      }
    },
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-notify');

  // Register tasks
  grunt.registerTask('default', [
    'sass',
    'uglify'
  ]);
  grunt.registerTask('dev', [
    'watch'
  ]);

};
