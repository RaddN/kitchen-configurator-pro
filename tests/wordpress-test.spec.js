// @ts-check
import { test, expect } from '@playwright/test';

test('configurator landing opens the design step in place', async ({ page }) => {
  const consoleMessages = [];

  page.on('console', (message) => {
    if (['error', 'warning'].includes(message.type())) {
      consoleMessages.push(`${message.type()}: ${message.text()}`);
    }
  });

  await page.goto('/configurator/');

  await expect(page).toHaveTitle(/configurator/i);
  await expect(page.locator('.kcp-shell-nav__logo')).toBeVisible();
  await expect(page.getByRole('heading', { name: /stel zelf je keuken samen/i })).toBeVisible();

  await page.getByRole('button', { name: /kies met greep/i }).click();

  await expect(page).toHaveURL(/\/configurator\/?$/);
  await expect(page.getByRole('heading', { name: /ontwerp jouw keuken/i })).toBeVisible();
  await expect(page.getByRole('link', { name: /selecteer kasten/i })).toBeVisible();
  expect(consoleMessages).toEqual([]);
});

test('target html routes render without canonical redirects', async ({ page }) => {
  const consoleMessages = [];

  page.on('console', (message) => {
    if (['error', 'warning'].includes(message.type())) {
      consoleMessages.push(`${message.type()}: ${message.text()}`);
    }
  });

  const routes = [
    {
      path: '/configurator.html',
      heading: /stel zelf je keuken samen/i,
    },
    {
      path: '/shop/vipp.html',
      heading: /gemaakt voor het leven/i,
    },
    {
      path: '/shop/vipp/verlichting/wandlamp.html',
      heading: /wandlamp/i,
    },
    {
      path: '/kasten/keukens-met-greep/onderkasten/onderkasten-met-deuren.html',
      heading: /onderkasten met deur\(en\)/i,
    },
    {
      path: '/kasten/keukens-met-greep/onderkasten/onderkasten-met-deuren/onderkasten-met-legplanken.html',
      heading: /onderkasten met legplanken/i,
    },
    {
      path: '/kasten/keukens-met-greep/onderkasten/onderkasten-met-deuren/onderkasten-met-legplanken/onderkast-met-deur.html',
      heading: /onderkast met deur/i,
    },
    {
      path: '/afrekenen.html',
      heading: /jouw winkelwagen is leeg/i,
    },
  ];

  for (const route of routes) {
    await page.goto(route.path);

    await expect(page).toHaveURL(new RegExp(`${route.path.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}$`));
    await expect(page.locator('.kcp-shell-nav__logo')).toBeVisible();
    await expect(page.getByRole('heading', { name: route.heading }).first()).toBeVisible();
  }

  expect(consoleMessages).toEqual([]);
});
