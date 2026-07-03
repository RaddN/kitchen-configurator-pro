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
