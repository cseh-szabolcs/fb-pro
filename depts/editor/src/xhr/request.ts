export async function request(
  path: string,
  method: 'GET' | 'POST' = 'GET',
) {

  const response = await fetch(`${window.APP_URL}${path}`, {
    method,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'Authorization': window.APP_AUTHORIZATION ? `Bearer ${window.APP_AUTHORIZATION}` : '0',
    },
  });

  return await response.json();
}
