#include <bits/stdc++.h>
using namespace std;

int main(){
   int k; cin>>k;
   //ok(0,0)
   int m=0,n=0;
   string c;
   cin>>c;
   for(char a:c){
      if(a=='U')n++;
      else if(a=='D')n--;
      else if(a=='L')m--;
      else m++;
   }
   int x,y;
   cin>>x>>y;
   cout<<m<<" "<<n<<"\n";
   cout<<abs(m-y)+abs(n-x)<<"\n";
   return 0;
}