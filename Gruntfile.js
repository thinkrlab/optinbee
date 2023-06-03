module.exports = function (grunt) {
	'use strict';

	grunt.initConfig({
		copy: {
			main: {
				options: {
					mode: true,
				},
				src: [
					'**',
					'!node_modules/**',
					'!build/**',
					'!css/sourcemap/**',
					'!.git/**',
					'!.github/**',
					'!bin/**',
					'!.gitlab-ci.yml',
					'!cghooks.lock',
					'!tests/**',
					'!*.sh',
					'!*.map',
					'!Gruntfile.js',
					'!postcss.config.js',
					'!tailwind.config.js',
					'!package.json',
					'!.gitignore',
					'!phpunit.xml',
					'!README.md',
					'!sass/**',
					'!src/**',
					'!composer.json',
					'!composer.lock',
					'!package-lock.json',
					'!phpcs.xml.dist',
					'!.eslintignore',
					'!.eslintrc.json',
					'!.vscode/**',
					'!*.zip',
					'!webpack.config.js',
				],
				dest: 'package/optinbee/',
			},
		},

		compress: {
			main: {
				options: {
					archive: 'optinbee.zip',
					mode: 'zip',
					level: 5,
				},
				files: [
					{
						expand: true,
						cwd: 'package/',
						src: ['optinbee/**'],
						dest: '/',
					},
				],
			},
		},

		clean: {
			main: ['package'],
			zip: ['*.zip'],
		},
	});

	// Load grunt tasks
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-clean');

	grunt.registerTask('package', [
		'clean:zip',
		'copy:main',
		'compress:main',
		'clean:main',
	]);
};
