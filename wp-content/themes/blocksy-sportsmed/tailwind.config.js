/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php"],
  // prefix: "tw-",
  theme: {
    extend: {},
  },
  corePlugins: {
    preflight: false,
  },
  plugins: [require("@tailwindcss/forms")],
};
require("@tailwindcss/forms");
