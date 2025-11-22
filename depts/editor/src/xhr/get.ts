export async function get(path: string) {
  const response = await fetch(`${window.APP_URL}/${path}`);

  return await response.json();

}
