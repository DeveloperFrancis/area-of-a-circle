function calculateArea(radius) {
    const area = Math.PI * radius * radius;
    return area;
  }
  
  const radius = 5;
  const area = calculateArea(radius);
  console.log("Area of the circle with radius " + radius + " is: " + area);
  