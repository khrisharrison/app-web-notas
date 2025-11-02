import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global dark-mode toggle initializer.
// Looks for `#dark-mode-toggle`, `#dark-mode-icon`, `#dark-mode-label` in the DOM
// and persists the choice in localStorage. This ensures the toggle works across all pages.
document.addEventListener('DOMContentLoaded', () => {
	const darkToggle = document.getElementById('dark-mode-toggle');
	const darkIcon = document.getElementById('dark-mode-icon');
	const darkLabel = document.getElementById('dark-mode-label');

	if (!darkToggle || !darkIcon) return;

	const applyDark = () => {
		const enabled = localStorage.getItem('dark-mode') === 'true';
		if (enabled) {
			document.documentElement.classList.add('dark');
			darkToggle.setAttribute('aria-pressed', 'true');
			darkIcon.textContent = 'light_mode';
			if (darkLabel) darkLabel.textContent = 'Cambiar a modo claro';
		} else {
			document.documentElement.classList.remove('dark');
			darkToggle.setAttribute('aria-pressed', 'false');
			darkIcon.textContent = 'dark_mode';
			if (darkLabel) darkLabel.textContent = 'Cambiar a modo oscuro';
		}
		if (darkIcon.classList.contains('dark-icon-animate')) {
			setTimeout(() => darkIcon.classList.remove('dark-icon-animate'), 250);
		}
	};

	darkToggle.addEventListener('click', () => {
		const currently = localStorage.getItem('dark-mode') === 'true';
		localStorage.setItem('dark-mode', (!currently).toString());
		darkIcon.classList.add('dark-icon-animate');
		setTimeout(() => {
			applyDark();
			darkIcon.classList.remove('dark-icon-animate');
		}, 160);
	});

	if (localStorage.getItem('dark-mode') === null) {
		const prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
		localStorage.setItem('dark-mode', prefers ? 'true' : 'false');
	}

	applyDark();
});
