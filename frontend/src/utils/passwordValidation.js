export const evaluatePasswordStrength = (password) => {
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumbers = /\d/.test(password);
  const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);
  const isLongEnough = password.length >= 8;
  const strengthsText = 'Strength:' ;

  if (isLongEnough && hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChars) {
    return `${strengthsText} strong`;
  } else if (isLongEnough && (hasUpperCase || hasLowerCase) && (hasNumbers || hasSpecialChars)) {
    return `${strengthsText} medium`;
  } else {
    return `${strengthsText} weak`;
  }
};

export const validatePassword = (password) => {
  const lengthCheck = password.length >= 8;
  const numberCheck = /\d/.test(password);
  const specialCharCheck = /[!@#$%^&*(),.?":{}|<>]/.test(password);
  const upperCaseCheck = /[A-Z]/.test(password);
  const lowerCaseCheck = /[a-z]/.test(password);

  return lengthCheck && numberCheck && specialCharCheck && upperCaseCheck && lowerCaseCheck;
};
