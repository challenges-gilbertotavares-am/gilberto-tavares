'use strict';

module.exports = () => {
	return {
		map: false,
		plugins: {
			autoprefixer: {
				cascade: false,
			},
			rtlcss: false,
		},
	};
};
