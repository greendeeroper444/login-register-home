<template>
  <div class="flex items-center justify-center min-h-screen relative bg-cover bg-center bg-no-repeat bg-background">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
      <h1 class="text-3xl font-bold text-center mb-4 text-gray-800">Welcome to Home Page</h1>
      <p class="text-lg mb-2 text-gray-700">
        <strong>Username:</strong> <span class="font-medium">{{ user?.username }}</span>
      </p>
      <p class="text-lg mb-4 text-gray-700">
        <strong>Password:</strong>
        <span class="font-mono text-sm text-gray-600 break-words">{{ user?.password }}</span>
      </p>
      <button
        @click="handleLogout"
        class="w-full bg-[#1F41BB] hover:bg-[#1f41bbe3] text-white font-semibold py-2 rounded transition duration-200"
      >
        Logout
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

//initialize toast
const toast = useToast();

const router = useRouter();
const user = ref(null);

//retrieve user info from localStorage on mount
onMounted(() => {
  const userInfo = localStorage.getItem('user');
  if (userInfo) {
    user.value = JSON.parse(userInfo); //parse and assign user data
  }
});

const handleLogout = () => {
  //clear login state and redirect to login
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('user');

  toast.success('You have logged out successfully!');
  router.push('/login');
}

</script>

<style scoped>
.bg-background {
  background-image: url('@/assets/background.png');
  background-size: cover;
  background-position: center;
}
</style>