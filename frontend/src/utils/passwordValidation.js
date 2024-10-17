// utils.js

/**
 * Validates a password based on specific criteria.
 * @param {string} password - The password to validate.
 * @returns {boolean} - Returns true if the password is valid, false otherwise.
 */
export const validatePassword = (password) => {
  const minLength = 8;
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumbers = /[0-9]/.test(password);
  const hasSymbols = /[!@#$%^&*(),.?":{}|<>]/.test(password);

  return (
    password.length >= minLength &&
    hasUpperCase &&
    hasLowerCase &&
    hasNumbers &&
    hasSymbols
  );
};

/**
 * Evaluates the strength of a password.
 * @param {string} password - The password to evaluate.
 * @returns {string} - Returns 'weak', 'medium', or 'strong'.
 */
export const evaluatePasswordStrength = (password) => {
  let strength = 'weak';

  if (password.length >= 8) {
    let score = 0;
    if (/[A-Z]/.test(password)) score++; //has upper case
    if (/[a-z]/.test(password)) score++; //has lower case
    if (/[0-9]/.test(password)) score++; //has number
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score++; //has symbol

    //assign strength based on score
    if (score < 2) {
      strength = 'weak';
    } else if (score === 2) {
      strength = 'medium';
    } else {
      strength = 'strong';
    }
  }

  return strength;
};
